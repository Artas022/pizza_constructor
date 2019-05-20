<?php

namespace common\models;


class ServiceMakecustompizza
{
    private $pirep;

    public function __construct(PizzaIngridientRepozitory $PizzaIngridientRepozitory)
    {
        $pirep = $PizzaIngridientRepozitory;
    }

    public function make($POST)
    {
        // ассоциативный массив для записи рецептуры в JSON
        $custom_pizza = [
            'ingridient_name' => [],
            'portion' => [],
            'base' => 0,
        ];
        $model = new CreatePizzaForm();
        $ingridients = new PizzaIngridient();
        $items = ArrayHelper::map(Ingridient::find()->all(), 'id_ingridient', 'name');
        if ($model->load($POST) && $ingridients->load($POST)) {
            $order = new Order();
            // Добавляем из модели формы /информацию
            $order->phonenumber = $model->phonenumber;
            $custom_pizza['base'] = $model->base;
            foreach ($ingridients['ingridient_id'] as $ingridient) {
                // ищем по номеру имя ингредиента и его стоимость
                $name_ingridient = $this->pirep->getallIngridients();
                // Добавляем порции и название ингредиентов
                array_push($custom_pizza['portion'], $ingridient['portions']);
                array_push($custom_pizza['ingridient_name'], $name_ingridient['name']);
                // считаем стоимость заказа
                $order->payment += ($name_ingridient['price'] / 100) * $ingridient['portions'];
            }
            $order->payment = round($order->payment);
            // зашифровать в JSON формат и сохранить в поле заказа
            $order->custom_pizza = json_encode($custom_pizza);
            $order->save();
        }

    }
}

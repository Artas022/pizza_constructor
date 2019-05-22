<?php

namespace common\models;

use frontend\models\CreatePizzaForm;
use frontend\models\OrderForm;
use Yii;

class ServicePizza
{
    private $pirep;
    
    public $model; // модель 

    public function __construct(PizzaRepository $PizzaRepository)
    {
        $this->pirep = $PizzaRepository;
    }
    
    public function AllPizza()
    {
        return $this->pirep->getMapPizza();
    }
    
    public function AllIngridients()
    {
        return $this->pirep->getMapIngridients();
    }

    // заказ обычной пиццы
    public function create_Pizza($POST)
    {
        $this->model = new OrderForm();
        if ($this->model->load($POST) && $this->model->validate()) {
            foreach ($this->model['id_pizza'] as $item) {
                $order = new Order();
                $order->phonenumber = $this->model->phonenumber;
                $order->id_pizza = $item;
                $pizza = Pizza::findOne(['id_pizza' => $item]);
                $order->payment = $pizza['price'];
                $order->status = 0;
                $order->save();
            }
            Yii::$app->session->setFlash('success', 'Ваш заказ успешно отправлен в обработку! Наш сотрудник свяжется с вами в скором времени!');
            return true;
        }
    }

    // Кастомная пицца
    public function create_CustomPizza($POST)
    {
        // загрузка моделей и валидация
        $this->model = new CreatePizzaForm();
        $this->model->load($POST);

        if ($this->model->load($POST) && $this->model->validate())
        {
            // ассоциативный массив для записи рецептуры в JSON
                $custom_pizza = [
                    'ingridient_name' => [],
                    'portion' => [],
                    'base' => 0,
                ];
                // модель заказа
                $order = new Order();
                // Добавляем из модели формы информацию:
                // основание, телефон
                $order->phonenumber = $this->model->phonenumber; 
                $custom_pizza['base'] = $this->model->base;
                // перечень ингредиентов

                foreach ($this->model['id_ingridient'] as $ingridient)
                {
                    // ищем по номеру имя ингредиента и его стоимость
                    $name_ingridient = $this->pirep->getIngridientName($ingridient);
                    // Добавляем порции и название ингредиентов
                    array_push($custom_pizza['portion'], $ingridient['portions']);
                    array_push($custom_pizza['ingridient_name'], $name_ingridient['name']);
                    // считаем стоимость заказа
                    $order->payment += ($name_ingridient['price'] / 100) * $ingridient['portions'];
                }
                $this->pirep->getMapIngridients();
                $order->payment = round($order->payment);
                // зашифровать в JSON формат и сохранить в поле заказа
                $order->custom_pizza = json_encode($custom_pizza);
                $order->save();
                Yii::$app->session->setFlash('success', 'Ваш особый заказ принят! Наш сотрудник свяжется с вами в скором времени!');
            return true;
        }
    }
}

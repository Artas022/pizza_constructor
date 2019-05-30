<?php

namespace common\models;

use frontend\models\CreatePizzaForm;
use frontend\models\OrderForm;
use Yii;

class ServicePizza
{
    private $pirep;
    
    public function __construct(PizzaRepository $PizzaRepository)
    {
        $this->pirep = $PizzaRepository;
    }

    public function create($POST, &$model, &$ingridients)
    {
        $model = new Pizza();
        $ingridients = new PizzaIngridient();
        // загружаем и проверяем на валидность данные модели
        if (($model->load($POST) && $ingridients->load($POST) && ($model->validate())))
        {
            foreach ($ingridients['ingridient_id'] as $item)
            {
                $temp = Ingridient::findOne($item['ingridient_id']);
                // Результат записываем в стоимость пиццы
                $model->price += $temp['price']/100*$item['portions'];
            }

            $model->price = round($model->price);
            $model->save();

            foreach ($ingridients['ingridient_id'] as $ingridient)
            {
                // Экземпляр пиццы
                $model2 = new PizzaIngridient();
                // даём номер пиццы
                $model2->pizza_id = $model->id_pizza;
                // даём порцию и номер ингредиента
                $model2->portions = $ingridient['portions'];
                $model2->ingridient_id = $ingridient['ingridient_id'];
                $model2->save();
            }
            return true;
        }
    }

    public function delete($id)
    {
        $ingridients = new PizzaIngridient();
        $model = Pizza::findOne($id);
        // удаляем ингредиенты из связной таблицы
        $ingridients->deleteAll(['pizza_id' => $model['id_pizza']]);
        // удаляем пиццу из таблицы пицц
        $model->delete();
    }
    
    public function update($POST,$id, &$model, &$ingridients)
    {
        $ingridients = new PizzaIngridient();
        $model = Pizza::findOne($id);
        if ($model->load($POST) && $model->save())
            return true;
    }
    // заказ обычной пиццы
    public function Order_Pizza($POST, &$model)
    {
        $model = new OrderForm();
        if ($model->load($POST) && $model->validate()) {
            foreach ($model['id_pizza'] as $item) {
                $order = new Order();
                $order->phonenumber = $model->phonenumber;
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

    public function Order_AjaxPizza($data)
    {
        // проход по всем позициям выбора пользователя
            for($i = 0; $i < count($data['pizza']); $i++)
            {
                $order = new Order();
                // находим id пиццы
                $id_pizza = $this->pirep->getIdPizzabyTitle($data['pizza'][$i]);
                // записываем данные в заказ (телефон, id пиццы, стоимость)
                $order->phonenumber = $data['phonenumber'];
                $order->id_pizza = $id_pizza['id_pizza'];
                $order->payment = $id_pizza['price'];
                $order->status = 0;
                // сохраняем модель
                $order->save();
            }
            return true;
    }
    // Кастомная пицца
    public function Order_CustomPizza($POST, &$model)
    {
        // загрузка моделей и валидация
        $model = new CreatePizzaForm();

        if ($model->load($POST) && $model->validate())
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
                $order->phonenumber = $model->phonenumber;
                $custom_pizza['base'] = $model->base;
                // перечень ингредиентов

                foreach ($model['id_ingridient'] as $ingridient)
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

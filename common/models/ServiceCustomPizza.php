<?php

namespace common\models;

use frontend\models\CreatePizzaForm;
use Yii;

class ServiceCustomPizza
{
    private $pirep;

    public function __construct(CustomPizzaRepository $CustomPizzaRepository)
    {
        $this->pirep = $CustomPizzaRepository;
    }
    
    public function create($POST, CreatePizzaForm $model)
    {
        // загрузка моделей
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
                $order->payment = round($order->payment);
                // зашифровать в JSON формат и сохранить в поле заказа
                $order->custom_pizza = json_encode($custom_pizza);
                $order->save();
                Yii::$app->session->setFlash('success', 'Ваш особый заказ принят! Наш сотрудник свяжется с вами в скором времени!');
            return true;
        }
    }
}

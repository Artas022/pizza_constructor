<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 22.05.19
 * Time: 17:02
 */

namespace common\models;
use common\models\Pizza;

class OrderRepository
{
    // получение всех заказов
    public function getAllOrders()
    {
        return Order::find()->all();
    }
    // поиск рецептуры кастомной пиццы
    public function getRecept($id)
    {
        if(Order::find()->select('custom_pizza')->where(['id_order' => $id])->exists())
        {
            $sql = Order::find()->select('custom_pizza')->where(['id_order' => $id])->one();
            return (array)json_decode($sql['custom_pizza']);
        }
        // если пицца не кастомная - ничего не выводить
        else
            return false;
    }
}
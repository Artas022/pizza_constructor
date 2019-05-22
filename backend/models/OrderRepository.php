<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 22.05.19
 * Time: 17:02
 */

namespace backend\models;


use common\models\Order;

class OrderRepository
{
    public function getAllOrders()
    {
        return Order::find()->all();
    }
    
    public function getOrder($id)
    {
        return Order::find()->select('custom_pizza')->where(['id_order' => $id])->one();
    }
}
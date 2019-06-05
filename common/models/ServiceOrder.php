<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 22.05.19
 * Time: 17:02
 */

namespace common\models;


use common\models\Order;

class ServiceOrder
{
    private $order;
    
    public $model;
    
    public function __construct(OrderRepository $OrderRepository)
    {
        $this->order = $OrderRepository;
        $this->model = new Order();
    }
    
    public function create($POST)
    {
        if ($this->model->load($POST) && $this->model->save())
            return true;
        else
            return false;
    }
    
    public function OrderView($id)
    {
        $sql = $this->order->getOrder($id);
        return (array) json_decode($sql['custom_pizza']);
    }
}
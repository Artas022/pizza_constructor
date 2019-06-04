<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }
    
    public function rules()
    {
        return [
            [['phonenumber', 'payment'], 'required'],
            [['id_pizza', 'status'], 'integer'],
            [['payment'], 'number'],
            [['phonenumber'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_order' => 'Номер заказа',
            'phonenumber' => 'Номер телефона',
            'id_pizza' => 'Номер пиццы',
            'payment' => 'К оплате, UAH',
            'status' => 'Статус выполнения',
        ];
    }
}

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
    
    public static function ShowRecept($ingridients)
    {
        if($ingridients)
        {
            echo '<p class="lead">' . 'Рецептура заказной пиццы c основанием ' . $ingridients['base'] . ' см:' . '</p>';
            for($i = 0; $i < count($ingridients['ingridient_name']); $i++)
            {
                echo '<strong>' . 'Ингредиент: ' . $ingridients['ingridient_name'][$i] . ', порция: ' . $ingridients['portion'][$i] . '</strong>' .'<br>';
            }
        }
    }

}

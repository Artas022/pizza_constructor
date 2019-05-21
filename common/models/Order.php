<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id_order
 * @property string $phonenumber
 * @property int $id_pizza
 * @property string $payment
 * @property int $status
 */
class Order extends \yii\db\ActiveRecord
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

    public static function CreateOrder($model)
    {
        foreach ($model['id_pizza'] as $item)
        {
            $order = new Order();
            $order->phonenumber = $model->phonenumber;
            $order->id_pizza = $item;
            $pizza = Pizza::findOne(['id_pizza' => $item]);
            $order->payment = $pizza['price'];
            $order->status = 0;
            $order->save();

        }
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

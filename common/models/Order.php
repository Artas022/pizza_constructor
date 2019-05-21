<?php

namespace common\models;

use Yii;

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
        Yii::$app->session->setFlash('success', 'Ваш заказ успешно отправлен в обработку! Наш сотрудник свяжется с вами в скором времени!');
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

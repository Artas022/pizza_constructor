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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phonenumber', 'id_pizza', 'payment'], 'required'],
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

    public function CreateCustomOrder($model,$pizza)
    {
        $this->phonenumber = $model->phonenumber;
        $this->id_pizza = $pizza->id_pizza;
        $this->payment = $pizza['price']/100;
        $this->status = 0;
        $this->save();
    }

    public static function CreateOrder($model)
    {
        foreach ($model['id_pizza'] as $item)
        {
            $order = new Order();
            $order->phonenumber = $model->phonenumber;
            $order->id_pizza = $item;
            $pizza = Pizza::findOne(['id_pizza' => $item]);
            $order->payment = $pizza['price']/100;
            $order->status = 0;
            $order->save();

        }
    }

}

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

    /**
     * {@inheritdoc}
     */
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

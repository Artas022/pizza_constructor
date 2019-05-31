<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 14.05.19
 * Time: 18:00
 */

namespace frontend\models;


use yii\base\Model;

class OrderForm extends Model
{
    public $phonenumber;
    public $id_pizza;

    public function attributeLabels()
    {
        return [
            'phonenumber' => 'Ваш мобильный номер',
            'id_pizza' => 'Пиццы',
        ];
    }

    public function rules()
    {
        return [
            [['phonenumber', 'id_pizza'], 'required', 'message' => 'Не может быть пустым!'],
            [['phonenumber'], 'number', 'min' => 6, 'message' => 'Не менее 6-ти цифр!'],
        ];
    }
    
}
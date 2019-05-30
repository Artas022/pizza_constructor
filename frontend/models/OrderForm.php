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
            [['phonenumber'], 'is8NumbersOnly'],
        ];
    }

    public function is8NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{8}$/', $this->$attribute)) {
            $this->addError($attribute, 'Должен состоять из цифр, не менее 8-ми');
        }
    }
    
}
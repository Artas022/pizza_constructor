<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 15.05.19
 * Time: 17:53
 */

namespace frontend\models;

use common\models\Ingridient;
use yii\base\Model;

class CreatePizzaForm extends Model
{
    public $base;
    public $phonenumber;
    public $id_ingridient; // && portions

    public function attributeLabels()
    {
        return [
            'phonenumber' => 'Номер телефона',
            'base' => 'Основание пиццы, в см',
            'id_ingridient' => 'Ингредиент',
        ];
    }

    public function rules()
    {
        return [
            [['base','phonenumber','id_ingridient'],'required'],
            ['phonenumber', 'is8NumbersOnly'],
            ['base', 'integer', 'message' => 'Должно быть целочисленным значением!'],
        ];
    }

    public function is8NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{8}$/', $this->$attribute)) {
            $this->addError($attribute, 'Должен состоять из цифр, не менее 8-ми');
        }
    }

}
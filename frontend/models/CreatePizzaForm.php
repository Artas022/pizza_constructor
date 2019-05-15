<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 15.05.19
 * Time: 17:53
 */

namespace frontend\models;

use yii\base\Model;

class CreatePizzaForm extends Model
{
    public $base;
    public $phonenumber;
    public $id_ingridient;

    public function attributeLabels()
    {
        return [
            'base' => 'Основание пиццы, в см',
            'id_ingridient' => 'Ингредиент',
        ];
    }

    public function rules()
    {
        return [
            [['phonenumber'], 'string', 'max' => 20],
            [['base', 'id_ingridient','phonenumber'], 'required'],
            [['base'], 'integer'],
        ];
    }
}
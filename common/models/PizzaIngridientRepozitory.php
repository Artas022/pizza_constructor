<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 20.05.19
 * Time: 16:52
 */

namespace common\models;


class PizzaIngridientRepozitory
{
    public function  getallIngridients()
    {
        return PizzaIngridient::find()->all();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 20.05.19
 * Time: 16:52
 */

namespace common\models;

class CustomPizzaRepository
{
    // Нахождение ингредиента по имени
    public function getIngridientName($ingridient)
    {
        return Ingridient::find()
            ->select(['price','name'])
            ->where(['id_ingridient' => $ingridient['ingridient_id']])
            ->one();
    }
}
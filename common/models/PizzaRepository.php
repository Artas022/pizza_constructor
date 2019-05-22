<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 20.05.19
 * Time: 16:52
 */

namespace common\models;

use common\models\Ingridient;
use common\models\Pizza;
use yii\helpers\ArrayHelper;

class PizzaRepository
{
    // Нахождение ингредиента по имени
    public function getIngridientName($ingridient)
    {
        return Ingridient::find()
            ->select(['price','name'])
            ->where(['id_ingridient' => $ingridient['ingridient_id']])
            ->one();
    }

    // список всех ингредиентов
    public function getMapIngridients()
    {
        return ArrayHelper::map(Ingridient::find()->all(), 'id_ingridient', 'name');
    }

    // список всех пицц
    public function getMapPizza()
    {
        return ArrayHelper::map(Pizza::find()->all(),'id_pizza','title');
    }

}
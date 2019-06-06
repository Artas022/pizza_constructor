<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 06.06.19
 * Time: 15:22
 */

namespace common\models;


use yii\helpers\ArrayHelper;

class IngridientRepository
{
    // Нахождение ингредиентов пиццы по ID
    public function getPizzaIngridients($id)
    {
        return PizzaIngridient::find()->joinWith(['pizza','ingridient'])->asArray()->where(['pizza_id' => $id])->all();;
    }
    // MAP всех ингредиентов для конструктора
    public function getMapIngridients()
    {
        return ArrayHelper::map(Ingridient::find()->all(), 'id_ingridient', 'name');
    }
    // Нахождение ингредиента по ID
    public function getIngridientName($ingridient)
    {
        return Ingridient::find()
            ->select(['price','name'])
            ->where(['id_ingridient' => $ingridient['ingridient_id']])
            ->one();
    }
    // Нахождение цены ингредиента по ID
    public function getIngridientPriceName($id)
    {
        return Ingridient::find()->select(['price','name'])->where(['id_ingridient' => $id])->one();
    }
    // нахождение ID и перечень всех ингредиентов
    public function getAllIngridients()
    {
        return Ingridient::find()->select(['id_ingridient','name'])->all();
    }
    // проверка ингредиента на наличие по имени
    public static function isIngridientExist($id)
    {
        if(Ingridient::find()->where(['id_ingridient' => $id])->exists())
            return true;
        else
            return false;
    }
}
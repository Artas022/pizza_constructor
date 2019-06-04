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
    // список всех ингредиентов для конструктора
    public function getMapIngridients()
    {
        return ArrayHelper::map(Ingridient::find()->all(), 'id_ingridient', 'name');
    }
    // Существует ли пицца по ID
    public function isPizzaExist($id)
    {
       if(Pizza::find()->where(['id_pizza' => $id])->exists())
           return true;
        else
            return false;
    }
    // Нахождение цены пиццы по имени
    public function getIngridientPriceName($id)
    {
        return Ingridient::find()->select(['price','name'])->where(['id_ingridient' => $id])->one();
    }
    // Нахождение ингредиентов пиццы
    public function getPizzaIngridients($id)
    {
        return PizzaIngridient::find()->joinWith(['pizza','ingridient'])->asArray()->where(['pizza_id' => $id])->all();;
    }
    // Нахождение ID и стоимости пиццы по названию
    public function getIdPizzabyTitle($title)
    {
        return Pizza::find()->select(['id_pizza', 'price'])->where(['title' => $title])->one();
    }
    // нахождение ID и имени всех ингредиентов
    public function getAllIngridients()
    {
        return Ingridient::find()->select(['id_ingridient','name'])->all();
    }
    // список всех пицц для заказа
    public function getMapPizza()
    {
        return ArrayHelper::map(Pizza::find()->select('')->all(),'id_pizza','title');
    }
    // проверка ингредиента на наличие по имени
    public function isIngridientExist($id)
    {
        if(Ingridient::find()->where(['id_ingridient' => $id])->exists())
            return true;
        else
            return false;
    }
    // перечень всех пицц (ID, title)
    public function getAllPizzaIdTitle()
    {
        return Pizza::find()->select(['id_pizza','title'])->all();
    }
    // Получение пиццы по ID
    public function getPizzaById($id)
    {
        return Pizza::find()->where(['id_pizza' => $id])->one();
    }
    // перечень всех готовых пицц
    public function getAllPizza()
    {
        return Pizza::find()->all();
    }
    // выводд модели пиццы
    public function view($id)
    {
        return Pizza::findOne($id);
    }

}
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

    public function isPizzaExist($id)
    {
       if(Pizza::find()->where(['id_pizza' => $id])->exists())
           return true;
        else
            return false;
    }
    
    public function getIngridientPrice($name)
    {
        return Ingridient::find()->select('price')->where(['name' => $name])->one();
    }
    
    public function getPizzaIngridients($id)
    {
        return PizzaIngridient::find()->joinWith(['pizza','ingridient'])->asArray()->where(['pizza_id' => $id])->all();;
    }

    public function getIdPizzabyTitle($title)
    {
        return Pizza::find()->select(['id_pizza', 'price'])->where(['title' => $title])->one();
    }

    // список всех пицц для заказа
    public function getMapPizza()
    {
        return ArrayHelper::map(Pizza::find()->select('')->all(),'id_pizza','title');
    }

    // проверка ингредиента на наличие по имени
    public function isIngridientExistbyName($name)
    {
        if(Ingridient::find()->where(['name' => $name])->exists())
            return true;
        else
            return false;
    }
        
    // перечень всех пицц (ID, title)
    public function getAllPizzaIdTitle()
    {
        return Pizza::find()->select(['id_pizza','title'])->all();
    }
    
    public function getPizzaById($id)
    {
        return Pizza::find()->where(['id_pizza' => $id])->one();
    }
    
    // перечень всех готовых пицц
    public function getAllPizza()
    {
        return Pizza::find()->all();
    }

    public function view($id)
    {
        return Pizza::findOne($id);
    }

}
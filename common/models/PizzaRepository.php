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
    // существует ли пицца по ID
    public function isPizzaExist($id)
    {
       if(Pizza::find()->where(['id_pizza' => $id])->exists())
           return true;
        else
            return false;
    }
    
    // нахождение ID и стоимости пиццы по названию
    public function getIdPizzabyTitle($title)
    {
        return Pizza::find()->select(['id_pizza', 'price'])->where(['title' => $title])->one();
    }
    
    // список всех пицц для заказа
    public static function getMapPizza()
    {
        return ArrayHelper::map(Pizza::find()->select('')->all(),'id_pizza','title');
    }
    
    // получение цены пиццы по ID
    public static function getPrice($id)
    {
        $model = Pizza::find()->select('price')->where(['id_pizza' => $id])->one();
        return $model['price'];
    }
    
    // получение имён и ID всех готовых пицц
    public static function getAllNotCustomPizza()
    {
        return Pizza::find()->select(['id_pizza','title'])->where(['title'] != null)->asArray()->all();
    }
    
    // перечень всех пицц (ID, title)
    public function getAllPizzaIdTitle()
    {
        return Pizza::find()->select(['id_pizza','title'])->all();
    }
    
    // получение пиццы по ID
    public function getPizzaById($id)
    {
        return Pizza::find()->where(['id_pizza' => $id])->one();
    }
    
    // перечень всех готовых пицц
    public function getAllPizza()
    {
        return Pizza::find()->all();
    }
    
    // вывод модели пиццы
    public function view($id)
    {
        return Pizza::findOne($id);
    }

}
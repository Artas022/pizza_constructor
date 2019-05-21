<?php

namespace common\models;

use Yii;

class Ingridient extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ingridient';
    }
    
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['name'],'unique'],
            [['price'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id_ingridient' => 'Номер ингредиента',
            'name' => 'Название',
            'price' => 'Цена UAH за 100 грамм',
        ];
    }

    public function getPizzaIngridients()
    {
        return $this->hasMany(PizzaIngridient::className(), ['ingridient_id' => 'id_ingridient']);
    }
    
    public function getPizzas()
    {
        return $this->hasMany(Pizza::className(), ['id_pizza' => 'pizza_id'])->viaTable('pizza_ingridient', ['ingridient_id' => 'id_ingridient']);
    }
    
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ingridient".
 *
 * @property int $id_ingridient
 * @property string $name
 * @property string $price
 *
 * @property PizzaIngridient[] $pizzaIngridients
 * @property Pizza[] $pizzas
 */
class Ingridient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingridient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ingridient' => 'Номер ингредиента',
            'name' => 'Название',
            'price' => 'Цена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPizzaIngridients()
    {
        return $this->hasMany(PizzaIngridient::className(), ['ingridient_id' => 'id_ingridient']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPizzas()
    {
        return $this->hasMany(Pizza::className(), ['id_pizza' => 'pizza_id'])->viaTable('pizza_ingridient', ['ingridient_id' => 'id_ingridient']);
    }
}

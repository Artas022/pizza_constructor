<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pizza_ingridient".
 *
 * @property int $pizza_id
 * @property double $portions
 * @property int $ingridient_id
 *
 * @property Ingridient $ingridient
 * @property Pizza $pizza
 */
class PizzaIngridient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pizza_ingridient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pizza_id', 'ingridient_id'], 'required'],
            [['pizza_id', 'ingridient_id'], 'integer'],
            [['portions'], 'number'],
            [['pizza_id', 'ingridient_id'], 'unique', 'targetAttribute' => ['pizza_id', 'ingridient_id']],
            [['ingridient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingridient::className(), 'targetAttribute' => ['ingridient_id' => 'id_ingridient']],
            [['pizza_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pizza::className(), 'targetAttribute' => ['pizza_id' => 'id_pizza']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pizza_id' => 'Pizza ID',
            'portions' => 'Portions',
            'ingridient_id' => 'Ingridient ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngridient()
    {
        return $this->hasOne(Ingridient::className(), ['id_ingridient' => 'ingridient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPizza()
    {
        return $this->hasOne(Pizza::className(), ['id_pizza' => 'pizza_id']);
    }
    
    // сохранение рецептуры в связную БД
    public function saveIngridients($id_pizza)
    {
            foreach ($this['ingridient_id'] as $ingridient)
            {
                // Экземпляр пиццы
                $model = new PizzaIngridient();
                // даём номер пиццы
                $model->pizza_id = $id_pizza;
                // даём порцию и номер ингредиента
                $model->portions = $ingridient['portions'];
                $model->ingridient_id = $ingridient['ingridient_id'];
                $model->save();
            }
    }
}

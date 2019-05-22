<?php

namespace common\models;

use Yii;

class PizzaIngridient extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pizza_ingridient';
    }
    
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
    
    public function attributeLabels()
    {
        return [
            'pizza_id' => 'Pizza ID',
            'portions' => 'Portions',
            'ingridient_id' => 'Ingridient ID',
        ];
    }
    
    public function getIngridient()
    {
        return $this->hasOne(Ingridient::className(), ['id_ingridient' => 'ingridient_id']);
    }
    
    public function getPizza()
    {
        return $this->hasOne(Pizza::className(), ['id_pizza' => 'pizza_id']);
    }
}

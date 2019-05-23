<?php

namespace common\models;

use phpDocumentor\Reflection\Types\Null_;
use common\models\Ingridient;
use Yii;


class Pizza extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pizza';
    }
    public function rules()
    {
        return [
            [['base'], 'integer'],
            [['price'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'],'unique'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id_pizza' => '№ пиццы ',
            'title' => 'Название',
            'base' => 'Основание, см',
            'price' => 'Цена, UAH',
        ];
    }
}

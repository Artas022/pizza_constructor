<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pizza".
 *
 * @property int $id_pizza
 * @property string $title
 * @property int $base
 * @property string $price
 */
class Pizza extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pizza';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base'], 'integer'],
            [['price'], 'number'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
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

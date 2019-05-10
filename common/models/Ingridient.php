<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ingridient".
 *
 * @property int $id_ingridient
 * @property string $name
 * @property double $dose
 * @property string $price
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
            [['name', 'dose', 'price'], 'required'],
            [['dose', 'price'], 'number'],
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
            'name' => 'Название ингредиента',
            'dose' => 'Порция, в граммах',
            'price' => 'Цена, UAH',
        ];
    }
}

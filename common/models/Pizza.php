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

    public function CreateCustomPizza($model, $ingridients)
    {
        $this->base = $model->base;
        $this->title = 'Custom';
        // Считаем стоимость пиццы по id ингредиентов в foreach
        foreach ($ingridients['ingridient_id'] as $item)
        {
            $temp = Ingridient::findOne($item['ingridient_id']);
            // Результат записываем в стоимость пиццы
            // Смотрим цену за 1 грамм и считаем по кол-ву порций
            $this->price += ($temp['price']/100)*$item['portions'];
        }
        $this->price = round($this->price);
        $this->save();
    }

    public function setPrice($ingridients)
    {
        foreach ($ingridients['ingridient_id'] as $item)
        {
            $temp = Ingridient::findOne($item['ingridient_id']);
            // Результат записываем в стоимость пиццы
            $this->price += $temp['price']/100*$item['portions'];
        }
        $this->price = round($this->price);
        $this->save();
    }
}

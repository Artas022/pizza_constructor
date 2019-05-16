<?php

namespace common\models;

use phpDocumentor\Reflection\Types\Null_;
use common\models\Ingridient;
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
            [['price'], 'integer'],
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
            'is_custom' => "Сделанная в конструкторе"
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
            $this->price += $temp['price']/100*$item['portions'];
        }
        $this->price /= 100; $this->price = round($this->price);
        $this->is_custom = 1;
        $this->save();
    }

    public function setPrice($ingridients)
    {
        $this->is_custom = 0;
        foreach ($ingridients['ingridient_id'] as $item)
        {
            $temp = Ingridient::findOne($item['ingridient_id']);
            // Результат записываем в стоимость пиццы
            $this->price += $temp['price']/100*$item['portions'];
        }
        $this->price /= 100; $this->price = round($this->price);
        $this->save();
    }
}

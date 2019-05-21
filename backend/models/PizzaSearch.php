<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pizza;

class PizzaSearch extends Pizza
{
    public function rules()
    {
        return [
            [['id_pizza'], 'integer'],
            [['title'], 'safe'],
            [['base', 'price'], 'number'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = Pizza::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id_pizza' => $this->id_pizza,
            'base' => $this->base,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        return $dataProvider;
    }
}

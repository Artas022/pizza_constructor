<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ingridient;

class IngridientSearch extends Ingridient
{
    public function rules()
    {
        return [
            [['id_ingridient'], 'integer'],
            [['name'], 'safe'],
            [['price'], 'number'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Ingridient::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id_ingridient' => $this->id_ingridient,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

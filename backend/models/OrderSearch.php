<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

class OrderSearch extends Order
{
    public function rules()
    {
        return [
            [['id_order', 'id_pizza', 'status'], 'integer'],
            [['phonenumber'], 'safe'],
            [['payment'], 'number'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = Order::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id_order' => $this->id_order,
            'id_pizza' => $this->id_pizza,
            'payment' => $this->payment,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'phonenumber', $this->phonenumber]);
        return $dataProvider;
    }
}

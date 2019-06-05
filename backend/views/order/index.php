<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Стол заказов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_order',
            'phonenumber',
            'payment',
            [
                'attribute' => 'id_pizza',
                'value' => function($data)
                {
                    if($data->id_pizza == null)
                        return 'Создана в конструкторе';
                    else
                    {
                       echo array_search($data->id_pizza,$pizza_titles['id_pizza']);
                    }
                }
            ],
            [
                'filter' => false,
                'attribute' => 'status',
                'value' => function($data){
                    return $data->status ? 'Выполнен' : 'В обработке';}
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

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
                'label' => 'Название пиццы',
                'attribute' => 'id_pizza',
                'value' => function($data) use($pizza_titles)
                {
                    if($data->id_pizza == null)
                        return 'Создана в конструкторе';
                    else
                        foreach ($pizza_titles as $item)
                            if($item['id_pizza'] == $data->id_pizza)
                                return $item['title'];
                }
            ],
            [
                'filter' => [null => 'Все', 0 => 'В обработке', 1 => 'Выполнены'],
                'attribute' => 'status',
                'value' => function($data){
                    return $data->status ? 'Выполнен' : 'В обработке';}
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

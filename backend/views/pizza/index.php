<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PizzaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пиццы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pizza-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Готовим новую пиццу!', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pizza',
            'title',
            'base',
            'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

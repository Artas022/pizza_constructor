<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Заказ №' . $model->id_order;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить статус', ['update', 'id' => $model->id_order], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить заказ', ['delete', 'id' => $model->id_order], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_order',
            'phonenumber',
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
            'payment',
            [
                'attribute' => 'status',
                'value' => function($data){
                    return $data->status ? 'Выполнен' : 'В обработке';}
            ]
        ],
    ]) ?>
    <?php
    if($reception)
        echo Yii::$app->view->render('recept',compact('reception'));
    ?>


</div>

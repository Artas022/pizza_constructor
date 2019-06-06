<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Обновить статус заказа: ' . $model->id_order;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_order, 'url' => ['view', 'id' => $model->id_order]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pizza_list' => $pizza_list,
    ]) ?>

</div>

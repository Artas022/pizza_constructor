<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pizza */

$this->title = 'Update Pizza: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pizzas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id_pizza]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pizza-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

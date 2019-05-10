<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ingridient */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ingridients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_ingridient]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ingridient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

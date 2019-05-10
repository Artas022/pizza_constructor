<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pizza */

$this->title = 'Приготовить новую пиццу';
$this->params['breadcrumbs'][] = ['label' => 'Pizzas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pizza-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'ingridi' => $ingridi,
    ]) ?>

</div>

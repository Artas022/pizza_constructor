<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Pizza */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Пиццы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pizza-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id_pizza], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id_pizza], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить выбранную пиццу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_pizza',
            'title',
            'base',
            'price',
        ],
    ]) ?>
    <p class="lead">Рецептура пиццы</p>
    <?php
    foreach ($ingridients as $ingridient)
    {
        echo '<strong>' . $ingridient['ingridient']['name'] . ', ' . $ingridient['portions'] . ' грамм' . '</strong>' . '<br>';
    }
    ?>

</div>

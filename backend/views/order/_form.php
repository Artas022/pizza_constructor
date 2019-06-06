<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phonenumber')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'id_pizza')->dropDownList($pizza_list) ?>

    <?= $form->field($model, 'payment')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        '0' => 'В обработке',
        '1' => 'Выполнен'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

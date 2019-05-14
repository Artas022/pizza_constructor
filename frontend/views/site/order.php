<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<h1>Страница оформления заказа</h1>
<p class="lead">Пожалуйста, заполните форму ниже:</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'phonenumber')->textInput(['maxlength' => true]) ?>

<// Полоса ингредиентов через select2 >

<?=
$form->field($model, 'id_pizza')->label('Ассортимент пицц:')->widget(Select2::classname(),[
    'name' => 'pizza',
    'data' => $items,
    'options' => [
        'placeholder' => 'Выберите одну или несколько пицц ...',
        'multiple' => true
    ],
]);
?>



<div class="form-group">
    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
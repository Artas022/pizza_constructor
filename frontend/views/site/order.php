<?php
$this->title = 'Страница заказа';
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<h1>Страница оформления заказа</h1>
<p class="lead">Пожалуйста, заполните форму ниже:</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'phonenumber')->textInput(['maxlength' => true]) ?>

<// Меню с множественным выбором пицц через Select2 >

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
    <?= yii\helpers\Html::a('Я сам соберу себе пиццу! &raquo', ['site/create'], ['class'=>'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<div class="pizza-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'base')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <// Полоса ингредиентов через select2 >

    <?=
        $form->field($ingridients, 'ingridient_id')->label('Ингредиенты для пиццы:')->widget(Select2::classname(),[
        'name' => 'ingridients',
        'data' => $items,
        'options' => [
        'placeholder' => 'Укажите один или несколько ингридиентов ...',
        'multiple' => true
        ],
        ]);
    ?>



<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php
?>
</div>

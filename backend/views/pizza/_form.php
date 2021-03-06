<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;

?>

<div class="pizza-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'base')->textInput() ?>

    <// Полоса ингредиентов через MultipliInput >

    <?= $form->field($ingridients, 'ingridient_id')->label("Рецептура пиццы")->widget(MultipleInput::className(), [
        'max' => 15,
        'columns' => [
            [
                'name'  => 'ingridient_id',
                'type'  => 'dropDownList',
                'title' => 'Ингредиент',
                'defaultValue' => 1,
                'items' => $items,
            ],
            [
                'name'  => 'portions',
                'title' => 'Порция',
                'enableError' => true,
                'options' => [
                    'class' => 'input-priority'
                ]
            ]
        ]
    ]);
    ?>
<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php
?>
</div>

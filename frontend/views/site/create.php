<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$this->title = 'Конструктор пицц';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, введите ваши данные</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'phonenumber')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'base')->textInput() ?>

            <// Полоса ингредиентов через Select2 >
    
            <?=
                $form->field($model, 'id_ingridient')->label('Список ингредиентов:')->widget(Select2::classname(),[
                    'name' => 'ingridients',
                    'data' => $items,
                    'options' => [
                        'placeholder' => 'Составьте свою рецептуру для пиццы ...',
                        'multiple' => true
                    ],
                ]);
            ?>

            <div class="form-group">
                <?= Html::submitButton('Подтвердить заказ', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

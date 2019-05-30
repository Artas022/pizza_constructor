<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\MultipleInput;
use yii\helpers;
use yii\helpers\Url;

$this->title = 'Конструктор пицц';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <a style="color: black; text-decoration: none;" href="<?=Url::toRoute(['site/ajaxcreate'])?>">Перейти на страницу с AJAX запросом... </a>
    <p>Наше заведение позволяет создать собственну пиццу благодаря нашему конструктору!</p>
    <p>Вы можете сами выбрать размер основания пиццы и перечень доступных вам ингредиентов, вплоть до их порций!</p>
    <p class="lead">Пожалуйста, введите ваши данные:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'phonenumber')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'base')->textInput() ?>

            <// Полоса ингредиентов через MultipleInput >

        <?= $form->field($model, 'id_ingridient')->label("Рецептура пиццы")->widget(MultipleInput::className(), [
            'max' => 5,
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
                        'class' => 'input-priority',
                    ]
                ]
            ]
        ]);
?>
            <div class="form-group">
                <?= Html::submitButton('Подтвердить заказ', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

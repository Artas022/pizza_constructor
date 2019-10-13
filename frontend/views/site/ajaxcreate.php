<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\MultipleInput;
$this->registerJsFile('@web/js/createform.js');
$this->title = 'Конструктор пицц';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="lead">Пожалуйста, введите ваши данные:</p>
    <div class="container">
        <div class="row">
                <form id="form-constructor">
                    <!-- Номер телефона -->
                    <div class="form-group" id="phonenumber_div">
                        <label for="phonenumber">Ваш номер телефона</label>
                        <input type="number" class="form-control" id="phonenumber">
                    </div>
                    <!-- Основание -->
                    <div class="form-group" id="base_form">
                        <label for="base">Основание пиццы, см</label>
                        <input type="number" class="form-control" id="base">
                    </div>
                    <!-- Выбор ингредиентов и их порций -->
                    <div id="recept">
                        <div class="row ingr-port">
                            <div class="col-lg-6">
                                <div class="form-group select-ingridient">
                                    <label>Рецептура пиццы</label>
                                    <select class="form-control select-field">
                                        <?php
                                        foreach ($items as $ingridient)
                                            echo '<option value="' . $ingridient['id_ingridient'] . '"=>'. $ingridient['name'] . '</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Порции</label>
                                <input type="number" class="form-control portion">
                            </div>
                        </div>
                    </div>
        </div>
        <br>
        <?= Html::submitButton('Отправить', ['class' => 'submit btn btn-success']) ?>
        <?= Html::Button('+', ['class' => 'submit btn btn-primary', 'id' => 'add_field']) ?>
        <?= Html::Button('-', ['class' => 'submit btn btn-danger', 'id' => 'delete_field']) ?>
        </form>
    </div>
    <div id="answer">
    </div>
</div>

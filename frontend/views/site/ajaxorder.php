<?php
$this->title = 'Страница заказа';
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<h1>Страница оформления заказа</h1>
<p class="lead">Пожалуйста, заполните форму ниже:</p>
<div id="form">

    <div class="fields">
        <label for="phonenumber">Ваш мобильный номер</label>
        <input type="number" class="form-control" id="phonenumber" placeholder="111222333">

        <div id="pizza-select">
            <label for="pizza">Выбор пицц</label>
            <select class="form-control" id="pizza">
                <?php
                foreach ($items as $item)
                    echo '<option>'. $item . '</option>';
                ?>
            </select>
        </div>
    </div>
</div>



<br>
<div class="form-group">
    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-success']) ?>
    <?= yii\helpers\Html::a('Я сам соберу себе пиццу! &raquo', ['site/create'], ['class'=>'btn btn-primary']) ?>
</div>

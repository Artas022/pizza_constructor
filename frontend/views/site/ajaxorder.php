<?php
use yii\helpers\Html;
$this->title = 'Страница заказа';
$this->registerJsFile('@web/js/orderform.js');
?>
<?= Html::csrfMetaTags() ?>
<h1>Страница оформления заказа</h1>
<p class="lead">Пожалуйста, заполните форму ниже:</p>
<div id="block-order">
    <form method="post" id="form-ajax" action="">
        <label for="phonenumber">Ваш мобильный номер</label>
        <input type="number" class="form-control" id="phonenumber" placeholder="...">
        <label for="pizza">Выбор пицц</label>
        <p class="lead">Для добавления ещё одной пиццы, используйте кнопку '+', для удаления - '-'</p>
        <p><?= Html::Button('+', ['class' => 'btn btn-primary', 'id' => 'add_field']) ?>
            <?= Html::Button('-', ['class' => 'btn btn-danger', 'id' => 'delete_field']) ?>
        </p>
        <div id="pizza-select">
            <select class="form-control pizza_field">
                <?php
                foreach ($items as $pizza)
                    echo '<option value="' . $pizza['id_pizza'] . '">'. $pizza['title'] . '</option>';
                ?>
            </select>
        </div>
    </form>
</div>
<br>
<div class="form-group">
    <?= Html::submitButton('Оформить заказ ', ['class' => 'btn btn-success', 'form' => 'form-ajax']) ?>
    <?= yii\helpers\Html::a('Я сам соберу себе пиццу! &raquo', ['site/create'], ['class'=>'btn btn-primary']) ?>
</div>



<?php

/* @var $this yii\web\View */

$this->title = 'Панель шефа';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Здравствуйте, шеф!</h1>
        <p class="lead">Чем Вы будете заниматься сегодня?</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <p class="lead">Пора пополнить запасы на кухне. Покажи мне, где здесь кладовая!</p>
                <?= yii\helpers\Html::a('Зайти в кладовую &raquo;', ['/ingridient'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="col-lg-4">
                <p class="lead">Я чувствую вдохновение! Я хочу создавать новые пиццы!</p>
                <?= yii\helpers\Html::a('Создать шедевр кулинарного дела &raquo', ['/pizza'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="col-lg-4">
                <p class="lead">Чего там так долго на кухне?! Время - деньги! Клиенты ждут!</p>
                <?= yii\helpers\Html::a('Проверить заказы &raquo', ['/order'], ['class'=>'btn btn-primary']) ?>
            </div>

        </div>

    </div>
</div>

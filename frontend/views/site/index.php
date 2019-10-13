<?php
use yii\helpers\Html;
$this->title = 'Основная страница';
?>
<div class="site-index">

    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Вы уже пробовали нашу пиццу?</h2>
                    <hr>
                    <p class="lead quote-block">
                        Мы используем самые лучшие ингредиенты, чтобы не просто готовить для вас - чтобы творить шедевры кулинарного искусства!
                        <br><br>
                        Мы 👨‍🍳 работаем не покладая рук, чтобы Вы оставались довольны!
                    </p>
                    <?= Html::a('Сделайте свой первый заказ! &raquo;', ['site/order'], ['class'=>'btn btn-dark-2']) ?>
                </div>
                <div class="col-sm-6">
                    <?= Html::img('@web/img/pizza_PNG44090.png', ['alt' => 'pizza_1']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= Html::img('@web/img/pizza_PNG44089.png', ['alt' => 'pizza_2', 'style' => ['width' => '100%']]) ?>
                </div>
                <div class="col-sm-6">
                    <h2>Хотите стать творцом?</h2>
                    <hr>
                    <p class="lead quote-block">
                        Мы разработали простой, но эффективный конструктор пиццы, где Вы можете сами создать свою собственную пиццу.
                    </p>
                    <?= Html::a('Перейти к конструктору &raquo;', ['site/ajaxcreate'], ['class'=>'btn btn-dark-2']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="row">
            <h1 align="center">Ознакомьтесь с нашим меню:</h1>
            <div class="container">
                <table class="table">
                    <thead>
                    <tr id="menu-table">
                        <th>Пицца</th>
                        <th>Основание, см</th>
                        <th>Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($menu as $pizza)
                    {
                        echo '
<tr>                
    <td>' . $pizza['title'] . '</td>
    <td>' . $pizza['base'] . '</td>
    <td>' . $pizza['price'] . ' UAH ' . '</td>
</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
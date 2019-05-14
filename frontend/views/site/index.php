<?php
$this->title = 'Основная страница';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Главная страница</h1>
        <p class="lead">Добро пожаловать в ресторан!</p>
    </div>
    <div class="body-content">
        <div class="row">
            <h1 align="center">Ознакомьтесь с нашим меню:</h1>
            <div class="container">
                <table class="table">
                    <thead>
                    <tr>
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
    <td>' . $pizza['price'] . '</td>
</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

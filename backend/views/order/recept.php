<div>
    <p>
        <?php
        echo '<p>';
        for($i = 0; $i< count($reception['ingridient_name']); $i++)
        {
            echo '<b>'
                . 'Ингредиент: ' . $reception['ingridient_name'][$i] . '. '
                . 'Порция: ' . $reception['portion'][$i]
                . '</b> <br>';
        }
        echo '</p>';
        ?>
    </p>
</div>
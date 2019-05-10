<?php

use yii\db\Migration;

class m190508_145756_create_ingridient_table extends Migration
{


    // Таблица с ингридиентами
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%ingridient}}', [
            // № ингридиента
            'id_ingridient' => $this->primaryKey(),
            // название ингридиента
            'name' => $this->string()->notNull(),
            // порция
            'dose' => $this->float()->notNull(),
            // цена ингридиента
            'price' => $this->money()->notNull(),
        ],$tableOptions);
    }
    
    public function safeDown()
    {
        $this->dropTable('{{%ingridient}}');
    }
}

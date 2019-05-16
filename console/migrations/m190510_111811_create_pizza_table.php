<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pizza}}`.
 */
class m190510_111811_create_pizza_table extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%pizza}}', [
            'id_pizza' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'base' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
            'is_custom' => $this->boolean()->defaultValue(0),
        ],$tableOptions);
    }
    public function safeDown()
    {
        $this->dropTable('{{%pizza}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pizza_ingridient}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%pizza}}`
 * - `{{%ingridient}}`
 */
class m190510_134214_create_junction_table_for_pizza_and_ingridient_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pizza_ingridient}}', [
            'pizza_id' => $this->integer(),
            'portions' => $this->float(),
            'ingridient_id' => $this->integer(),
            'PRIMARY KEY(pizza_id, ingridient_id)',
        ]);

        // creates index for column `pizza_id`
        $this->createIndex(
            '{{%idx-pizza_ingridient-pizza_id}}',
            '{{%pizza_ingridient}}',
            'pizza_id'
        );

        // add foreign key for table `{{%pizza}}`
        $this->addForeignKey(
            '{{%fk-pizza_ingridient-pizza_id}}',
            '{{%pizza_ingridient}}',
            'pizza_id',
            '{{%pizza}}',
            'id_pizza',
            'CASCADE'
        );

        // creates index for column `ingridient_id`
        $this->createIndex(
            '{{%idx-pizza_ingridient-ingridient_id}}',
            '{{%pizza_ingridient}}',
            'ingridient_id'
        );

        // add foreign key for table `{{%ingridient}}`
        $this->addForeignKey(
            '{{%fk-pizza_ingridient-ingridient_id}}',
            '{{%pizza_ingridient}}',
            'ingridient_id',
            '{{%ingridient}}',
            'id_ingridient',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%pizza}}`
        $this->dropForeignKey(
            '{{%fk-pizza_ingridient-pizza_id}}',
            '{{%pizza_ingridient}}'
        );

        // drops index for column `pizza_id`
        $this->dropIndex(
            '{{%idx-pizza_ingridient-pizza_id}}',
            '{{%pizza_ingridient}}'
        );

        // drops foreign key for table `{{%ingridient}}`
        $this->dropForeignKey(
            '{{%fk-pizza_ingridient-ingridient_id}}',
            '{{%pizza_ingridient}}'
        );

        // drops index for column `ingridient_id`
        $this->dropIndex(
            '{{%idx-pizza_ingridient-ingridient_id}}',
            '{{%pizza_ingridient}}'
        );

        $this->dropTable('{{%pizza_ingridient}}');
    }
}

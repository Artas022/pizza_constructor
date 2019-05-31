<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m190514_133247_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            // номер заказа
            'id_order' => $this->primaryKey(),
            // номер телефона
            'phonenumber' => $this->string(20)->notNull(),
            // номер пиццы, которую заказал клиент
            'id_pizza' => $this->integer(),
            // к оплате
            'payment' => $this->integer(),
            // рецептура кастомной пиццы
            'custom_pizza' => $this->json(),
            // статус выполнения заказа:
            // 0 - не выполнен, 1 - выполнен
            'status' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}

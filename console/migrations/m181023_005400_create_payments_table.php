<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payments`.
 */
class m181023_005400_create_payments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('payments', [
            'id' => $this->primaryKey(),
            //'date'=>$this->timestamp()->defaultValue('CURRENT_TIMESTAMP'),
            'date' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'price' => $this->integer()->defaultValue(15),
            'count' => $this->integer()->defaultValue(1),
            'amount' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('payments');
    }
}

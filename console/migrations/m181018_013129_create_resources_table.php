<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resources`.
 */
class m181018_013129_create_resources_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resources', [
            'id' => $this->primaryKey(),
            'name' => $this->string(24)->notNull(),
            'icon' => $this->string(255)->defaultValue("/backend/web/resourse/icon/unknown.png"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('resources');
    }
}

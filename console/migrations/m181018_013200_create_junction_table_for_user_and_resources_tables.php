<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_resources`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `resources`
 */
class m181018_013200_create_junction_table_for_user_and_resources_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_resources', [
            'user_id' => $this->integer(),
            'resources_id' => $this->integer(),
            'count' => $this->integer()->defaultValue(100),
            'PRIMARY KEY(user_id, resources_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_resources-user_id',
            'user_resources',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_resources-user_id',
            'user_resources',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `resources_id`
        $this->createIndex(
            'idx-user_resources-resources_id',
            'user_resources',
            'resources_id'
        );

        // add foreign key for table `resources`
        $this->addForeignKey(
            'fk-user_resources-resources_id',
            'user_resources',
            'resources_id',
            'resources',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-user_resources-user_id',
            'user_resources'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_resources-user_id',
            'user_resources'
        );

        // drops foreign key for table `resources`
        $this->dropForeignKey(
            'fk-user_resources-resources_id',
            'user_resources'
        );

        // drops index for column `resources_id`
        $this->dropIndex(
            'idx-user_resources-resources_id',
            'user_resources'
        );

        $this->dropTable('user_resources');
    }
}

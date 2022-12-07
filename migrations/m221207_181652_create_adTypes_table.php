<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%adTypes}}`.
 */
class m221207_181652_create_adTypes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%adTypes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%adTypes}}');
    }
}

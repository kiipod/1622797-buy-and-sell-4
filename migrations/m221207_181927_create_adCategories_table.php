<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%adCategories}}`.
 */
class m221207_181927_create_adCategories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%adCategories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%adCategories}}');
    }
}

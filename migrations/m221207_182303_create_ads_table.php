<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ads}}`.
 */
class m221207_182303_create_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ads}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'imageSrc' => $this->string(255)->notNull(),
            'typeId' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'author' => $this->integer()->notNull(),
            'email' => $this->string(64)->notNull(),
            'dateCreation' => $this->dateTime()
                ->defaultExpression('CURRENT_TIMESTAMP')->notNull()
        ]);

        $this->addForeignKey(
            'ads_type',
            'ads',
            'typeId',
            'adTypes',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'ads_author',
            'ads',
            'author',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('ads_type', 'ads');
        $this->dropForeignKey('ads_author', 'ads');
        $this->dropTable('{{%ads}}');
    }
}

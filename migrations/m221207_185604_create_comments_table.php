<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m221207_185604_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'author' => $this->integer()->notNull(),
            'adId' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'dateCreation' => $this->dateTime()
                ->defaultExpression('CURRENT_TIMESTAMP')->notNull()
        ]);

        $this->addForeignKey(
            'comment_author',
            'comments',
            'author',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'comment_ads',
            'comments',
            'adId',
            'ads',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('comment_ads', 'comments');
        $this->dropForeignKey('comment_author', 'comments');
        $this->dropTable('{{%comments}}');
    }
}

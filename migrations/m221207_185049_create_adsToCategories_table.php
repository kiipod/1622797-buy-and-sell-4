<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%adsToCategories}}`.
 */
class m221207_185049_create_adsToCategories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%adsToCategories}}', [
            'id' => $this->primaryKey(),
            'adId' => $this->integer()->notNull(),
            'categoryId' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'category_ads_id',
            'adsToCategories',
            'adId',
            'ads',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'ads_category_id',
            'adsToCategories',
            'categoryId',
            'adCategories',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('ads_category_id', 'adsToCategories');
        $this->dropForeignKey('category_ads_id', 'adsToCategories');
        $this->dropTable('{{%adsToCategories}}');
    }
}

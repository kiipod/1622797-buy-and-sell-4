<?php

use yii\db\Migration;

/**
 * Class m221211_184628_add_column_price_ads_table
 */
class m221211_184628_add_column_price_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ads', 'price', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221211_184628_add_column_price_ads_table cannot be reverted.\n";

        return false;
    }
}

<?php

use yii\db\Migration;

/**
 * Class m221207_191328_add_data_to_AdTypes
 */
class m221207_191328_add_data_to_AdTypes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'adTypes',
            ['name'],
            [
                ['Продам'],
                ['Куплю'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221207_191328_add_data_to_AdTypes cannot be reverted.\n";

        return false;
    }
}

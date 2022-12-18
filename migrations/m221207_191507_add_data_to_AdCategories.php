<?php

use yii\db\Migration;

/**
 * Class m221207_191507_add_data_to_AdCategories
 */
class m221207_191507_add_data_to_AdCategories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'adCategories',
            ['name', 'icon'],
            [
                ['Дом'],
                ['Спорт и отдых'],
                ['Авто'],
                ['Электроника'],
                ['Одежда'],
                ['Книги'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221207_191507_add_data_to_AdCategories cannot be reverted.\n";

        return false;
    }
}

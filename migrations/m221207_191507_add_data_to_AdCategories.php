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
                ['Дом', 'home'],
                ['Спорт и отдых', 'sport'],
                ['Авто', 'auto'],
                ['Электроника', 'tech'],
                ['Одежда', 'clothes'],
                ['Книги', 'books'],
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

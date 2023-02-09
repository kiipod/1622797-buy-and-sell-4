<?php

namespace app\models\forms;

use yii\base\Model;

class SearchForm extends Model
{
    public string $search = '';

    public function rules(): array
    {
        return [
            ['search', 'match', 'pattern' => '/^[A-Za-zА-Яа-яЁё\s]{2,50}$/u']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'search' => ''
        ];
    }
}

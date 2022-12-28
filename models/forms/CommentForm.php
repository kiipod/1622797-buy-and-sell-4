<?php

namespace app\models\forms;

use yii\base\Model;

class CommentForm extends Model
{
    public const MESSAGE_MIN_LENGTH = 20;
    public string $author = '';
    public int $adId;
    public string $comment = '';

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'comment' => 'Текст комментария'
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['author', 'adId', 'comment'], 'required'],
            [['comment'], 'string', 'min' => self::MESSAGE_MIN_LENGTH]
        ];
    }
}

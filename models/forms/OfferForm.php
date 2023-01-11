<?php

namespace app\models\forms;

use app\models\AdTypes;
use yii\base\Model;

class OfferForm extends Model
{
    private const TITLE_MIN_LENGTH = 10;
    private const TITLE_MAX_LENGTH = 100;
    private const DESCRIPTION_MIN_LENGTH = 50;
    private const DESCRIPTION_MAX_LENGTH = 1000;
    private const MIN_PRICE = 100;

    public $image;
    public $name;
    public $description;
    public $categories;
    public $price;
    public $typeId;

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'image' => 'Изображения',
            'name' => 'Название',
            'description' => 'Описание',
            'categories' => 'Категория публикации',
            'price' => 'Цена',
            'typeId' => 'Тип объявления'
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'description', 'price', 'image', 'typeId', 'categories'], 'required'],
            [['name'], 'string', 'min' => self::TITLE_MIN_LENGTH, 'max' => self::TITLE_MAX_LENGTH],
            [['description'], 'string', 'min' => self::DESCRIPTION_MIN_LENGTH, 'max' => self::DESCRIPTION_MAX_LENGTH],
            [['price'], 'number', 'min' => self::MIN_PRICE],
            [['typeId'], 'exist', 'targetClass' => AdTypes::class, 'targetAttribute' => ['typeId' => 'id']],
            [['image'], 'image', 'extensions' => 'png, jpg', 'maxSize' => 5 * 1024 * 1024]
        ];
    }
}

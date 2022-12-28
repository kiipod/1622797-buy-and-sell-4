<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "ads".
 *
 * @property int $id
 * @property string $name
 * @property string $imageSrc
 * @property int $typeId
 * @property string $description
 * @property int $author
 * @property string $dateCreation
 * @property int $price
 *
 * @property AdsToCategories[] $adsToCategories
 * @property Users $authorAds
 * @property Comments[] $comments
 * @property AdTypes $type
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'imageSrc', 'typeId', 'description', 'author'], 'required'],
            [['typeId', 'author', 'price'], 'integer'],
            [['description'], 'string'],
            [['dateCreation'], 'safe'],
            [['name', 'imageSrc'], 'string', 'max' => 255],
            [['author'], 'exist', 'skipOnError' => true,
                'targetClass' => Users::class, 'targetAttribute' => ['author' => 'id']],
            [['typeId'], 'exist', 'skipOnError' => true,
                'targetClass' => AdTypes::class, 'targetAttribute' => ['typeId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'imageSrc' => 'Image Src',
            'typeId' => 'Type ID',
            'description' => 'Description',
            'author' => 'Author',
            'dateCreation' => 'Date Creation',
            'price' => 'Price'
        ];
    }

    /**
     * Gets query for [[AdsToCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdsToCategories(): ActiveQuery
    {
        return $this->hasMany(AdsToCategories::class, ['adId' => 'id']);
    }

    /**
     * Gets query for [[AuthorAds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorAds(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'author']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comments::class, ['adId' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType(): ActiveQuery
    {
        return $this->hasOne(AdTypes::class, ['id' => 'typeId']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads".
 *
 * @property int $id
 * @property string $name
 * @property string $imageSrc
 * @property int $typeId
 * @property string $description
 * @property int $author
 * @property string $email
 * @property string $dateCreation
 * @property int $price
 *
 * @property AdsToCategories[] $adsToCategories
 * @property Users $author0
 * @property Comments[] $comments
 * @property AdTypes $type
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'imageSrc', 'typeId', 'description', 'author', 'email'], 'required'],
            [['typeId', 'author', 'price'], 'integer'],
            [['description'], 'string'],
            [['dateCreation'], 'safe'],
            [['name', 'imageSrc'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 64],
            [['author'], 'exist', 'skipOnError' => true,
                'targetClass' => Users::class, 'targetAttribute' => ['author' => 'id']],
            [['typeId'], 'exist', 'skipOnError' => true,
                'targetClass' => AdTypes::class, 'targetAttribute' => ['typeId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'imageSrc' => 'Image Src',
            'typeId' => 'Type ID',
            'description' => 'Description',
            'author' => 'Author',
            'email' => 'Email',
            'dateCreation' => 'Date Creation',
            'price' => 'Price'
        ];
    }

    /**
     * Gets query for [[AdsToCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdsToCategories()
    {
        return $this->hasMany(AdsToCategories::class, ['adId' => 'id']);
    }

    /**
     * Gets query for [[Author0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'author']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['adId' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(AdTypes::class, ['id' => 'typeId']);
    }
}

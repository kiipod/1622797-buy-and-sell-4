<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adsToCategories".
 *
 * @property int $id
 * @property int $adId
 * @property int $categoryId
 *
 * @property Ads $ad
 * @property AdCategories $category
 */
class AdsToCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adsToCategories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adId', 'categoryId'], 'required'],
            [['adId', 'categoryId'], 'integer'],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => AdCategories::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['adId'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::class, 'targetAttribute' => ['adId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adId' => 'Ad ID',
            'categoryId' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Ad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ads::class, ['id' => 'adId']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(AdCategories::class, ['id' => 'categoryId']);
    }
}

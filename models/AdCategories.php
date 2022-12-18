<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adCategories".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 *
 * @property AdsToCategories[] $adsToCategories
 */
class AdCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adCategories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'icon'], 'string', 'max' => 64],
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
            'icon' => 'Icon'
        ];
    }

    /**
     * Gets query for [[AdsToCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdsToCategories()
    {
        return $this->hasMany(AdsToCategories::class, ['categoryId' => 'id']);
    }
}

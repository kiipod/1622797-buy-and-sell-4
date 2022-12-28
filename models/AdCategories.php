<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "adCategories".
 *
 * @property int $id
 * @property string $name
 *
 * @property AdsToCategories[] $adsToCategories
 */
class AdCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'adCategories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name'
        ];
    }

    /**
     * Gets query for [[AdsToCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdsToCategories(): ActiveQuery
    {
        return $this->hasMany(AdsToCategories::class, ['categoryId' => 'id']);
    }
}

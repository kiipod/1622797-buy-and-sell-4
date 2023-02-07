<?php

namespace app\models;

use Yii;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $author
 * @property int $adId
 * @property string $text
 * @property string $dateCreation
 *
 * @property Ads $ad
 * @property Users $authorUser
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author', 'adId', 'text'], 'required'],
            [['author', 'adId'], 'integer'],
            [['text'], 'string'],
            [['dateCreation'], 'safe'],
            [['adId'], 'exist', 'skipOnError' => true,
                'targetClass' => Ads::class, 'targetAttribute' => ['adId' => 'id']],
            [['author'], 'exist', 'skipOnError' => true,
                'targetClass' => Users::class, 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'adId' => 'Ad ID',
            'text' => 'Text',
            'dateCreation' => 'Date Creation',
        ];
    }

    /**
     * Gets query for [[Ad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasOne(Ads::class, ['id' => 'adId']);
    }

    /**
     * Gets query for [[Author0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorUser()
    {
        return $this->hasOne(Users::class, ['id' => 'author']);
    }

    /**
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function deleteComment(): void
    {
        $this->delete();
    }
}

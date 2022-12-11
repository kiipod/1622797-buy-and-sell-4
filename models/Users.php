<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $lastName
 * @property string $email
 * @property string $password
 * @property string|null $avatarSrc
 * @property int|null $vkId
 *
 * @property Ads[] $ads
 * @property Comments[] $comments
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lastName', 'email', 'password'], 'required'],
            [['vkId'], 'integer'],
            [['name', 'lastName', 'avatarSrc'], 'string', 'max' => 255],
            [['email', 'password'], 'string', 'max' => 64],
            [['email'], 'unique'],
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
            'lastName' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'avatarSrc' => 'Avatar Src',
            'vkId' => 'Vk ID',
        ];
    }

    /**
     * Gets query for [[Ads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::class, ['author' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['author' => 'id']);
    }
}

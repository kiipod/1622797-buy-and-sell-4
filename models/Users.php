<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $avatarSrc
 * @property int|null $vkId
 * @property int $admin
 *
 * @property Ads[] $ads
 * @property Comments[] $comments
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['username', 'email', 'password'], 'required'],
            [['vkId', 'admin'], 'integer'],
            [['username', 'avatarSrc'], 'string', 'max' => 255],
            [['email', 'password'], 'string', 'max' => 64],
            [['email'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'avatarSrc' => 'Avatar Src',
            'vkId' => 'Vk ID',
            'admin' => 'Admin'
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

    public static function findIdentity($id): Users|IdentityInterface|null
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}

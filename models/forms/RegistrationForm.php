<?php

namespace app\models\forms;

use app\models\Users;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $avatar;
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $repeatPassword = '';

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'avatar' => 'Аватар',
            'email' => 'Эл. почта',
            'username' => 'Имя и фамилия',
            'password' => 'Пароль',
            'repeatPassword' => 'Пароль еще раз'
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'email', 'password', 'repeatPassword', 'avatar'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['password', 'repeatPassword'], 'string', 'min' => 6],
            [['repeatPassword'], 'compare', 'compareAttribute' => 'password'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => Users::class,
                'targetAttribute' => ['email' => 'email'],
                'message' => 'Пользователь с таким e-mail уже существует'],
            [['avatar'], 'image', 'extensions' => 'png, jpg', 'maxSize' => 5 * 1024 * 1024]
        ];
    }
}

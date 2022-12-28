<?php

namespace buyandsell\services;

use app\models\forms\RegistrationForm;
use app\models\Users;
use Yii;
use yii\base\Exception;
use yii\web\ServerErrorHttpException;

class RegistrationService
{
    /** Метод сохраняет данные введенные при регистрации в БД
     *
     * @param RegistrationForm $form
     * @return bool
     * @throws Exception
     * @throws ServerErrorHttpException
     */
    public function registration(RegistrationForm $form): bool
    {
        $fileService = new FilesService();
        $user = new Users();
        $user->avatarSrc = $fileService->uploadFile($form->avatar, 'avatar');
        $user->username = $form->username;
        $user->email = $form->email;
        $user->password = Yii::$app->security->generatePasswordHash($form->password);

        return $user->save();
    }
}

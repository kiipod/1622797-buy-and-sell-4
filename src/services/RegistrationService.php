<?php

namespace buyandsell\services;

use app\models\forms\RegistrationForm;
use app\models\Users;
use Yii;
use yii\base\Exception;
use yii\rbac\DbManager;
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
        if ($user->save()) {
            $auth = new DbManager();
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());
        }
        return true;
    }

    /** Метод осуществляет регистрацию по аккаунту VK
     *
     * @param array $userData
     * @return void
     * @throws \Exception
     */
    public function vkRegistration(array $userData): void
    {
        $user = new Users();

        $user->username = $userData['first_name'] . ' ' . $userData['last_name'] ?? null;
        $user->email = $userData['email'] ?? null;
        $user->avatarSrc = $userData['photo_200_orig'] ?? null;
        $user->vkId = $userData['id'];
        if ($user->save()) {
            $auth = new DbManager();
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());
            Yii::$app->user->login($user);
            Yii::$app->response->redirect('/');
        }
    }
}

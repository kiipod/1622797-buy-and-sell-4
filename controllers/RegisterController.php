<?php

namespace app\controllers;

use app\models\forms\RegistrationForm;
use buyandsell\services\RegistrationService;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\ServerErrorHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class RegisterController extends Controller
{
    /**
     * @throws Exception
     * @throws ServerErrorHttpException
     */
    public function actionIndex(): Response|string
    {
        $registerForm = new RegistrationForm();

        if (Yii::$app->request->getIsPost()) {
            $registerForm->load(Yii::$app->request->post());
            $registerForm->avatar = UploadedFile::getInstance($registerForm, 'avatar');

            if ($registerForm->validate()) {
                $registrationService = new RegistrationService();
                if (!$registrationService->registration($registerForm)) {
                    throw new ServerErrorHttpException(
                        'Не удалось сохранить данные, попробуйте попытку позже'
                    );
                }
                return $this->redirect(['login/index']);
            }
        }
        return $this->render('index', ['registerForm' => $registerForm]);
    }
}

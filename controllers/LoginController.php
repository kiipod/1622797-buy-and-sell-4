<?php

namespace app\controllers;

use app\models\forms\LoginForm;
use app\models\Users;
use buyandsell\services\RegistrationService;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LoginController extends Controller
{
    /**
     * @return Response|array|string
     */
    public function actionIndex(): Response|array|string
    {
        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax && $loginForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);

                return $this->redirect('/');
            }
        }
        return $this->render('index', ['loginForm' => $loginForm]);
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect('/');
    }

    /**
     * @return void
     */
    public function actionAuth(): void
    {
        $url = Yii::$app->authClientCollection->getClient("vkontakte")->buildAuthUrl();
        Yii::$app->getResponse()->redirect($url);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function actionVk(): void
    {
        $code = Yii::$app->request->get('code');
        $vkClient = Yii::$app->authClientCollection->getClient("vkontakte");
        $accessToken = $vkClient->fetchAccessToken($code);
        $userAttributes = $vkClient->getUserAttributes();
        $user = Users::findOne(['email' => $userAttributes['email']]);

        if ($user) {
            if (!$user->vkId) {
                $user->vkId = $userAttributes['user_id'];
                $user->save();
            }
            Yii::$app->user->login($user);
            Yii::$app->response->redirect(['/']);
        } else {
            $registerService = new RegistrationService();
            $registerService->vkRegistration($userAttributes);
        }
    }
}

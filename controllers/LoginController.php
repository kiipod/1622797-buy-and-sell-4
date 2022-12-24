<?php

namespace app\controllers;

use app\models\forms\LoginForm;
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
}

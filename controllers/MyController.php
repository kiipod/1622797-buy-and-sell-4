<?php

namespace app\controllers;

use app\models\Ads;
use buyandsell\services\AdsService;
use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class MyController extends Controller
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function actionIndex(): string
    {
        $user = Yii::$app->user->getIdentity();
        $userAds = $user->getAds()->orderBy('dateCreation DESC')->all();

        return $this->render('index', [
            'userAds' => $userAds
        ]);
    }

    /**
     * @param $adId
     * @return Response
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($adId): Response
    {
        $ads = Ads::find()->with('comments')->where(['id' => $adId])->one();
        $adsService = new AdsService();

        $adsService->deleteAds($ads);

        return $this->redirect(['my/index']);
    }
}

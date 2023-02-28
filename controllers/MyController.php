<?php

namespace app\controllers;

use app\models\Ads;
use app\models\Comments;
use buyandsell\services\AdsService;
use buyandsell\services\CommentService;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class MyController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'comments'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['deleteComment'],
                        'allow' => true,
                        'roles' => ['controlOffer']
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['controlOffer']
                    ],
                ],
            ],
        ];
    }

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

    /**
     * @return string
     */
    public function actionComments(): string
    {
        $user = Yii::$app->user->getId();
        $commentService = new CommentService();

        $adsWithComments = $commentService->getUserAdsWithComments($user);

        return $this->render('comments', [
            'adsWithComments' => $adsWithComments
        ]);
    }

    /**
     * @param int $commentId
     * @return Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDeleteComment(int $commentId): Response
    {
        $comments = Comments::findOne($commentId);

        if (!$comments) {
            throw new NotFoundHttpException('Данный комментарий не найден', 404);
        }

        $comments->deleteComment();

        return $this->redirect(['my/comments']);
    }
}

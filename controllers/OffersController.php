<?php

namespace app\controllers;

use app\models\Ads;
use app\models\forms\CommentForm;
use app\models\forms\OfferForm;
use buyandsell\services\CommentService;
use buyandsell\services\CreateAdsService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class OffersController extends Controller
{
    /** Метод отвечающий за просмотр страницы Объявлений
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionView(int $id): string
    {
        $ads = Ads::findOne($id);
        if (!$ads) {
            throw new NotFoundHttpException("Объявления с ID $id не существует");
        }

        $commentForm = new CommentForm();
        $commentService = new CommentService();

        if (Yii::$app->request->getIsPost()) {
            $commentForm->load(Yii::$app->request->post());

            if ($commentForm->validate()) {
                if (!$commentService->createComment($commentForm, $ads)) {
                    throw new ServerErrorHttpException(
                        'Не удалось создать комментарий, попробуйте попытку позже'
                    );
                }
            }
        }

        return $this->render('view', [
            'ads' => $ads,
            'commentForm' => $commentForm
        ]);
    }

    /** Метод отвечает за показ страницы добавления нового объявления
     *
     * @return Response|string
     * @throws ServerErrorHttpException
     */
    public function actionAdd(): Response|string
    {
        $offerForm = new OfferForm();
        $createAdsService = new CreateAdsService();
        $author = Yii::$app->user->getId();

        if (Yii::$app->request->getIsPost()) {
            $offerForm->load(Yii::$app->request->post());
            $offerForm->image = UploadedFile::getInstance($offerForm, 'image');

            if ($offerForm->validate()) {
                if (!$createAdsService->createAds($offerForm, $author)) {
                    throw new ServerErrorHttpException(
                        'Не удалось создать новое объявление, повторите попытку позже'
                    );
                }
            }
        }
        return $this->render('add', ['offerForm' => $offerForm]);
    }

    /** Метод отвечает за показ страницы редактирования объявления
     *
     * @param int $id
     * @return string|Response
     * @throws ServerErrorHttpException
     */
    public function actionEdit(int $id): Response|string
    {
        $currentAds = Ads::find()->where(['id' => $id])->with('adsToCategories')->one();
        $author = Yii::$app->user->getId();

        $offerForm = new OfferForm();
        $adsEdit = new CreateAdsService();

        $adsEdit->autocompleteForm($offerForm, $currentAds);

        if (Yii::$app->request->getIsPost()) {
            $offerForm->load(Yii::$app->request->post());
            $offerId = $adsEdit->createAds($offerForm, $author);

            return $this->redirect(['offers/', 'id' => $offerId]);
        }
        return $this->render('edit', ['offerForm' => $offerForm]);
    }
}

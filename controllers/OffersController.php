<?php

namespace app\controllers;

use app\models\AdCategories;
use app\models\Ads;
use app\models\forms\CommentForm;
use app\models\forms\OfferForm;
use buyandsell\services\CommentService;
use buyandsell\services\CreateAdsService;
use buyandsell\services\AdsService;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class OffersController extends Controller
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
                        'actions' => ['view', 'category'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'roles' => ['createOffer']
                    ],
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['controlOwnOffer']
                    ],
                ],
            ],
        ];
    }

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

        $authorAds = $ads->author;

        $commentForm = new CommentForm();
        $commentService = new CommentService();

        if (Yii::$app->request->getIsPost()) {
            $commentForm->load(Yii::$app->request->post());

            if ($commentForm->validate()) {
                if (!$commentService->createComment($commentForm)) {
                    throw new ServerErrorHttpException(
                        'Не удалось создать комментарий, попробуйте попытку позже'
                    );
                }
            }
        }

        return $this->render('view', [
            'ads' => $ads,
            'authorAds' => $authorAds,
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
                return $this->redirect(['my/index']);
            }
        }
        return $this->render('add', ['offerForm' => $offerForm]);
    }

    /** Метод отвечает за показ страницы редактирования объявления
     *
     * @param int $id
     * @return string|Response
     * @throws ServerErrorHttpException
     * @throws Exception
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
            $offerForm->image = UploadedFile::getInstance($offerForm, 'image');

            if ($offerForm->validate()) {
                $adsEdit->deleteAdsToCategories($currentAds);
                $adsEdit->editAds($currentAds, $offerForm, $author);

                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('edit', ['offerForm' => $offerForm]);
    }

    /** Метод отвечает за показ страницы объявлений по заданным категориям
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory(int $id): string
    {
        $adsServices = new AdsService();

        $categoryAds = $adsServices->getCategoriesAds();
        $categoryAdsCount = $adsServices->getCategoryAdsToPagination($id);
        $currentCategory = AdCategories::findOne($id);

        if (!$currentCategory) {
            throw new NotFoundHttpException('Такой категории не существует', 404);
        }

        $adsToCategories = $adsServices->getAdsToCategories($id);

        $pagination = new Pagination([
            'totalCount' => $categoryAdsCount->count(),
            'pageSize' => 8,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);

        return $this->render('category', [
            'categoryAds' => $categoryAds,
            'currentCategory' => $currentCategory,
            'adsToCategories' => $adsToCategories,
            'pagination' => $pagination
        ]);
    }
}

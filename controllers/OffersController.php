<?php

namespace app\controllers;

use app\models\Ads;
use app\models\forms\CommentForm;
use buyandsell\services\CommentService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

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
                    throw new ServerErrorHttpException('Не удалось создать комментарий, попробуйте попытку позже');
                }
            }
        }

        return $this->render('view', [
            'ads' => $ads,
            'commentForm' => $commentForm
        ]);
    }
}

<?php

namespace buyandsell\services;

use app\models\Ads;
use app\models\Comments;
use app\models\forms\CommentForm;
use yii\web\ServerErrorHttpException;

class CommentService
{
    /** Метод сохраняет новый комментарий к объявлению
     *
     * @param CommentForm $form
     * @return bool
     * @throws ServerErrorHttpException
     */
    public function createComment(CommentForm $form): bool
    {
        $comment = new Comments();
        $comment->author = $form->author;
        $comment->adId = $form->adId;
        $comment->text = $form->comment;

        if (!$comment->save()) {
            throw new ServerErrorHttpException('Комментарий не удалось сохранить');
        }
        return $comment->save();
    }

    /** Метод отвечает за выборку постов с комментариями конкретного человека
     *
     * @param int $user
     * @return array
     */
    public function getUserAdsWithComments(int $user): array
    {
        return Ads::find()->with('comments')->where(['author' => $user])
            ->orderBy('dateCreation DESC')->all();
    }
}

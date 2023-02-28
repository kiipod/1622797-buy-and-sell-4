<?php

namespace app\rbac;

use app\models\Ads;
use app\models\Comments;
use Yii;
use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param $user
     * @param $item
     * @param $params
     * @return bool
     */
    public function execute($user, $item, $params): bool
    {
        $ads = Ads::findOne(Yii::$app->request->get('adId'));
        if ($ads && $ads->author === $user) {
            return true;
        }

        $comments = Comments::findOne(Yii::$app->request->get('commentId'));
        if ($comments && $comments->ads->author === $user) {
            return true;
        }

        return false;
    }
}

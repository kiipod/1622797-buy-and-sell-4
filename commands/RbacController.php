<?php

namespace app\commands;

use app\rbac\AuthorRule;
use Yii;
use yii\base\Exception;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @return void
     * @throws Exception
     * @throws \Exception
     */
    public function actionInit(): void
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $admin->description = 'Модератор';
        $auth->add($admin);

        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);

        $rule = new AuthorRule();
        $auth->add($rule);

        $createOffer = $auth->createPermission('createOffer');
        $createOffer->description = 'Добавить объявление';
        $auth->add($createOffer);
        $auth->addChild($user, $createOffer);

        $controlOffer = $auth->createPermission('controlOffer');
        $controlOffer->description = 'Контроль объявления';
        $auth->add($controlOffer);
        $auth->addChild($admin, $controlOffer);

        $controlOwnOffer = $auth->createPermission('controlOwnOffer');
        $controlOwnOffer->description = 'Контроль собственного объявления';
        $controlOwnOffer->ruleName = $rule->name;
        $auth->add($controlOwnOffer);

        $auth->addChild($controlOwnOffer, $controlOffer);
        $auth->addChild($user, $controlOwnOffer);
        $auth->addChild($admin, $user);
    }
}

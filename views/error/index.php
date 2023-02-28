<?php

/** @var yii\web\View $this
 * @var string $errorCode
 */

use app\models\forms\SearchForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<section class="error">
    <h1 class="error__title"><?= Yii::$app->getErrorHandler()->exception->statusCode; ?></h1>
    <h2 class="error__subtitle"><?= $errorCode ?></h2>
    <ul class="error__list">
        <?php if (Yii::$app->user->isGuest) : ?>
        <li class="error__item">
            <a href="<?= Url::toRoute('register/index'); ?>">Вход и регистрация</a>
        </li>
        <?php else : ?>
        <li class="error__item">
            <a href="<?= Url::toRoute('offers/add'); ?>">Новая публикация</a>
        </li>
        <?php endif; ?>
        <li class="error__item">
            <a href="<?= Url::toRoute('/'); ?>">Главная страница</a>
        </li>
    </ul>
    <?php
    $searchForm = new SearchForm();

    $form = ActiveForm::begin([
        'options' => ['class' => 'error__search search search--small'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n
                    <div class=\"search__icon\"></div>\n
                    {error}",
        ],
        'action' => ['search/index'],
        'method' => 'get'
    ]);
    ?>
    <?= $form->field($searchForm, 'search')->textInput(['placeholder' => 'Поиск']) ?>
    <div class="search__close-btn"></div>
    <?php ActiveForm::end() ?>
    <a class="error__logo logo" href="<?= Url::toRoute('/') ?>">
        <img src="/img/logo.svg" width="179" height="34" alt="Логотип Куплю Продам">
    </a>
</section>

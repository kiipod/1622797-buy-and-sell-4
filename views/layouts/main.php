<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\forms\SearchForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/img/favicon.ico')]);

$user = Yii::$app->user->getIdentity();
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<header class="header <?= Yii::$app->user->getId() ? 'header--logged' : '' ;?>">
    <div class="header__wrapper">
        <a class="header__logo logo" href="<?= Url::toRoute('/') ?>">
            <img src="../../img/logo.svg" width="179" height="34" alt="Логотип Куплю Продам">
        </a>
        <?php if (Yii::$app->user->getId()) : ?>
        <nav class="header__user-menu">
            <ul class="header__list">
                <li class="header__item">
                    <a href="<?= Url::toRoute('/my') ?>">Публикации</a>
                </li>
                <li class="header__item">
                    <a href="<?= Url::toRoute('/my/comments') ?>">Комментарии</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
        <?php $searchForm = new SearchForm();

        $form = ActiveForm::begin([
            'options' => ['class' => 'search'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n
                    <div class=\"search__icon\"></div>\n
                    {error}"
            ],
            'action' => ['search/index'],
            'method' => 'get'
        ]);
        ?>
        <?= $form->field($searchForm, 'search')->textInput(['placeholder' => 'Поиск']) ?>
            <div class="search__close-btn"></div>
        <?php ActiveForm::end(); ?>
        <?php if (Yii::$app->user->getId()) : ?>
        <a class="header__avatar avatar" href="<?= Url::toRoute('/my') ?>">
            <img src="/uploads/avatar/<?= $user->avatarSrc; ?>" srcset="/uploads/avatar/<?= $user->avatarSrc; ?> 2x"
                 alt="Аватар пользователя">
        </a>
        <?php endif; ?>
        <?php if (!Yii::$app->user->getId()) : ?>
        <a class="header__input" href="<?= Url::toRoute('/register') ?>">Вход и регистрация</a>
        <?php endif; ?>
    </div>
</header>

<main class="page-content">

        <?= $content; ?>

</main>

<footer class="page-footer">
    <div class="page-footer__wrapper">
        <div class="page-footer__col">
            <a href="https://htmlacademy.ru/"
               class="page-footer__logo-academy" aria-label="Ссылка на сайт HTML-Академии">
                <svg width="132" height="46">
                    <use xlink:href="../../img/sprite_auto.svg#logo-htmlac"></use>
                </svg>
            </a>
            <p class="page-footer__copyright">© 2019 Проект Академии</p>
        </div>
        <div class="page-footer__col">
            <a href="<?= Url::toRoute('/') ?>" class="page-footer__logo logo">
                <img src="../../img/logo.svg" width="179" height="35" alt="Логотип Куплю Продам">
            </a>
        </div>
        <div class="page-footer__col">
            <ul class="page-footer__nav">
                <?php if (!Yii::$app->user->getId()) : ?>
                <li>
                    <a href="<?= Url::toRoute('/register') ?>">Вход и регистрация</a>
                </li>
                <?php else : ?>
                <li>
                    <a href="<?= Url::toRoute('/offers/add') ?>">Создать объявление</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

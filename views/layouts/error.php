<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['meta_description']]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/img/favicon.ico')]);

$class = match (Yii::$app->getErrorHandler()->exception->statusCode) {
    404 => 'not-found',
    default => 'server',
};
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="ru" class="<?= "html-$class"; ?>">
<head>
    <title>Куплю Продам</title>
    <?php $this->head(); ?>
</head>
<?php $this->beginBody(); ?>
<body class="<?= "body-$class"; ?>">

<main>
    <?= $content ?>
</main>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>


<?php

/** @var yii\web\View $this
 * @var object $newAds
 * @var object $commentedAds
 * @var object $categoryAds
 * @var object $ads
 */

use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'Куплю Продам';
?>

<?php if (!$newAds) : ?>
<div class="message">
    <div class="message__text">
        <p>На сайте еще не опубликовано ни&nbsp;одного объявления.</p>
    </div>
    <a href="<?= Url::to('/register') ?>" class="message__link btn btn--big">Вход и регистрация</a>
</div>
<?php else : ?>
<section class="categories-list">
    <h1 class="visually-hidden">Сервис объявлений "Куплю - продам"</h1>
    <?= ListView::widget([
        'dataProvider' => $categoryAds,
        'itemView' => '_listCategory',
        'itemOptions' => ['tag' => false],
        'layout' => '{items}',
        'options' => [
            'tag' => 'ul',
            'class' => 'categories-list__wrapper',
        ]
    ]);
    ?>
</section>
<section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <p class="tickets-list__title">Самое свежее</p>
        </div>
        <?= ListView::widget([
            'dataProvider' => $newAds,
            'itemView' => '_listAds',
            'itemOptions' => ['tag' => false],
            'layout' => '{items}',
            'options' => [
                'tag' => 'ul'
            ]
        ]);
        ?>
    </div>
</section>
<?php if ($commentedAds->getCount() > 0) : ?>
<section class="tickets-list">
    <h2 class="visually-hidden">Самые обсуждаемые предложения</h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <p class="tickets-list__title">Самые обсуждаемые</p>
        </div>
        <?= ListView::widget([
        'dataProvider' => $commentedAds,
        'itemView' => '_listCommented',
        'itemOptions' => ['tag' => false],
        'layout' => '{items}',
        'options' => [
            'tag' => 'ul'
            ]
    ]);
        ?>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php

/** @var yii\web\View $this
 * @var object $userAds
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <a href="<?= Url::toRoute('/offers/add'); ?>" class="tickets-list__btn btn btn--big">
                <span>Новая публикация</span></a>
        </div>
        <ul>
            <?php foreach ($userAds as $ads) : ?>
            <li class="tickets-list__item js-card">
                <div class="ticket-card ticket-card--color06">
                    <div class="ticket-card__img">
                        <img src="/uploads/images/<?= $ads->imageSrc; ?>"
                             srcset="/uploads/images/<?= $ads->imageSrc; ?>@2x.jpg 2x"
                             alt="Изображение товара">
                    </div>
                    <div class="ticket-card__info">
                        <span class="ticket-card__label"><?= $ads->type->name; ?></span>
                        <div class="ticket-card__categories">
                            <?php foreach ($ads->adsToCategories as $adsCategory) : ?>
                            <a href="<?= Url::to(['offers/category/', 'id' => $adsCategory->category->id]); ?>">
                                <?= Html::encode($adsCategory->category->name); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="ticket-card__header">
                            <h3 class="ticket-card__title"><a href="<?= Url::toRoute(['offers/view',
                                    'id' => $ads->id]); ?>"><?= Html::encode($ads->name); ?></a></h3>
                            <p class="ticket-card__price"><span class="js-sum"><?= Html::encode($ads->price); ?>
                                </span> ₽</p>
                        </div>
                    </div>
                    <?= Html::a('Удалить', Url::to(['my/delete', 'adId' => $ads->id]),
                        ['class'=>'ticket-card__del js-delete']); ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

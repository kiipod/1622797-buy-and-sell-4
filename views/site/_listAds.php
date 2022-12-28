<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<li class="tickets-list__item">
    <div class="ticket-card ticket-card--color08">
        <div class="ticket-card__img">
            <img src="<?= $model->imageSrc; ?>" srcset="<?= $model->imageSrc; ?>@2x.jpg 2x"
                 alt="Изображение товара">
        </div>
        <div class="ticket-card__info">
            <span class="ticket-card__label"><?= $model->type->name; ?></span>
            <div class="ticket-card__categories">
                <?php foreach ($model->adsToCategories as $adsCategory) : ?>
                <a href="<?= Url::to(['offers/category/', 'id' => $adsCategory->category->id]); ?>">
                    <?= Html::encode($adsCategory->category->name); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="ticket-card__header">
                <h3 class="ticket-card__title"><a href="<?= Url::toRoute(['offers/view',
                        'id' => $model->id]); ?>">
                        <?= Html::encode($model->name); ?>
                    </a>
                </h3>
                <p class="ticket-card__price"><span class="js-sum"><?= Html::encode($model->price); ?></span> ₽</p>
            </div>
            <div class="ticket-card__desc">
                <p><?= substr(Html::encode($model->description) ,0 ,55); ?>...</p>
            </div>
        </div>
    </div>
</li>

<?php

/** @var yii\web\View $this
 * @var object $adsWithComments
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<section class="comments">
    <div class="comments__wrapper">
        <?php if (!$adsWithComments) : ?>
            <p class="comments__message">У ваших публикаций еще нет комментариев.</p>
        <?php else : ?>
        <h1 class="visually-hidden">Страница комментариев</h1>
            <?php foreach ($adsWithComments as $ads) : ?>
        <div class="comments__block">
            <div class="comments__header">
                <a href="<?= Url::to(['offers/view', 'id' => $ads->id]); ?>" class="announce-card">
                    <h2 class="announce-card__title"><?= Html::encode($ads->name); ?></h2>
                    <span class="announce-card__info">
              <span class="announce-card__price">₽ <?= Html::encode($ads->price); ?></span>
              <span class="announce-card__type"><?= $ads->type->name; ?></span>
            </span>
                </a>
            </div>
            <ul class="comments-list">
                <?php foreach ($ads->comments as $comment) : ?>
                <li class="js-card">
                    <div class="comment-card">
                        <div class="comment-card__header">
                            <a href="#" class="comment-card__avatar avatar">
                                <img src="/uploads/avatar/<?= $comment->authorUser->avatarSrc; ?>"
                                     srcset="/uploads/avatar/<?= $comment->authorUser->avatarSrc; ?> 2x"
                                     alt="Аватар пользователя">
                            </a>
                            <p class="comment-card__author"><?= Html::encode($comment->authorUser->username); ?></p>
                        </div>
                        <div class="comment-card__content">
                            <p><?= Html::encode($comment->text); ?></p>
                        </div>
                        <?= Html::a('Удалить', Url::to(['my/delete-comment', 'adId' => $ads->id,
                            'commentId' => $comment->id]),
                            ['class'=>'comment-card__delete js-delete']); ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
            <?php endforeach; ?>
        <?php endif; ?>
</section>

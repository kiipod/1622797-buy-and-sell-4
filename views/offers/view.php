<?php

/** @var yii\web\View $this
 * @var object $ads
 * @var object $commentForm
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$user = Yii::$app->user->getIdentity();

?>

<section class="ticket">
    <div class="ticket__wrapper">
        <h1 class="visually-hidden">Карточка объявления</h1>
        <div class="ticket__content">
            <div class="ticket__img">
                <img src="/uploads/images/<?= $ads->imageSrc; ?>"
                     srcset="/uploads/images/<?= $ads->imageSrc; ?>@2x.jpg 2x" alt="Изображение товара">
            </div>
            <div class="ticket__info">
                <h2 class="ticket__title"><?= Html::encode($ads->name); ?></h2>
                <div class="ticket__header">
                    <p class="ticket__price"><span class="js-sum"><?= Html::encode($ads->price); ?></span> ₽</p>
                    <p class="ticket__action"><?= Html::encode($ads->type->name); ?></p>
                </div>
                <div class="ticket__desc">
                    <p><?= Html::encode($ads->description); ?></p>
                </div>
                <div class="ticket__data">
                    <p>
                        <b>Дата добавления:</b>
                        <span><?= Yii::$app->formatter->asDate($ads->dateCreation, 'dd MMMM yyyy'); ?></span>
                    </p>
                    <p>
                        <b>Автор:</b>
                        <a href="#"><?= Html::encode($ads->authorAds->username); ?></a>
                    </p>
                    <p>
                        <b>Контакты:</b>
                        <a href="mailto:<?= Html::encode($ads->authorAds->email); ?>">
                            <?= Html::encode($ads->authorAds->email); ?></a>
                    </p>
                </div>
                <ul class="ticket__tags">
                    <?php foreach ($ads->adsToCategories as $adsCategory) : ?>
                    <li>
                        <a href="#" class="category-tile category-tile--small">
                <span class="category-tile__image">
                  <img src="img/cat.jpg" srcset="img/cat@2x.jpg 2x" alt="Иконка категории">
                </span>
                            <span class="category-tile__label"><?= $adsCategory->category->name; ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="ticket__comments">
            <?php if (Yii::$app->user->getIsGuest()) : ?>
                <div class="ticket__warning">
                    <p>Отправка комментариев доступна <br>только для зарегистрированных пользователей.</p>
                    <a href="<?= Url::toRoute('/register'); ?>" class="btn btn--big">Вход и регистрация</a>
                </div>
            <?php endif; ?>
            <h2 class="ticket__subtitle">Комментарии</h2>
            <?php if (!Yii::$app->user->getIsGuest()) : ?>
            <div class="ticket__comment-form">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'options' => ['class' => 'form comment-form'],
                    'errorCssClass' => 'form__field--invalid',
                    'fieldConfig' => [
                        'template' => '{input}{label}{error}',
                        'options' => ['class' => 'form__field'],
                        'errorOptions' => ['tag' => 'span']]
                ]);
                ?>
                    <div class="comment-form__header">
                        <a href="#" class="comment-form__avatar avatar">
                            <img src="/uploads/avatar/<?= $user->avatarSrc; ?>"
                                 srcset="img/avatar@2x.jpg 2x" alt="Аватар пользователя">
                        </a>
                        <p class="comment-form__author"><?= $user->username; ?></p>
                    </div>
                    <div class="comment-form__field">
                        <?= $form->field($commentForm, 'comment')->textarea(['class' => 'js-field']); ?>
                        <?= $form->field($commentForm, 'author', ['template' => '{input}'])
                            ->hiddenInput(['value' => Yii::$app->user->getId()]); ?>
                        <?= $form->field($commentForm, 'adId', ['template' => '{input}'])
                            ->hiddenInput(['value' => $ads->id]); ?>
                    </div>
                    <button class="comment-form__button btn btn--white js-button"
                            type="submit" disabled="">Отправить</button>
                <?php ActiveForm::end(); ?>
            </div>
            <?php endif; ?>
            <?php if (!$ads->comments) : ?>
                <div class="ticket__message">
                    <p>У этой публикации еще нет ни одного комментария.</p>
                </div>
            <?php else : ?>
            <div class="ticket__comments-list">
                <ul class="comments-list">
                    <?php foreach ($ads->getComments()->orderBy(['dateCreation' => SORT_DESC])->all() as $comment) : ?>
                    <li>
                    <div class="comment-card">
                        <div class="comment-card__header">
                            <a href="#" class="comment-card__avatar avatar">
                                <img src="/uploads/avatar/<?= $comment->authorUser->avatarSrc; ?>"
                                     srcset="img/avatar02@2x.jpg 2x" alt="Аватар пользователя">
                            </a>
                            <p class="comment-card__author"><?= $comment->authorUser->username; ?></p>
                        </div>
                        <div class="comment-card__content">
                            <p><?= $comment->text; ?></p>
                        </div>
                    </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <button class="chat-button" type="button" aria-label="Открыть окно чата"></button>
    </div>
</section>

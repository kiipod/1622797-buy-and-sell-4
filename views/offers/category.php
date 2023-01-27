<?php

/** @var yii\web\View $this
 * @var object $currentCategory
 * @var object $categoryAds
 * @var object $adsToCategories
 * @var object $pagination
 */

use yii\widgets\LinkPager;
use yii\widgets\ListView;

?>

<section class="categories-list">
    <h1 class="visually-hidden">Сервис объявлений "Куплю - продам"</h1>
    <?= ListView::widget([
        'dataProvider' => $categoryAds,
        'itemView' => '../site/_listCategory',
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
    <h2 class="visually-hidden">Предложения из категории <?= $currentCategory->name; ?></h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <p class="tickets-list__title"><?= $currentCategory->name; ?> <b class="js-qty">
                    <?= count($currentCategory->adsToCategories); ?></b></p>
        </div>
        <?php if (!$adsToCategories) : ?>
            <div class="message__text">
                <p>Объявления отсутствуют.</p>
            </div>
        <?php else : ?>
        <?= ListView::widget([
            'dataProvider' => $adsToCategories,
            'itemView' => '../site/_listAds',
            'itemOptions' => ['tag' => false],
            'layout' => '{items}',
            'options' => [
                'tag' => 'ul'
            ]
        ]);
        ?>
        <div class="tickets-list__pagination">
            <?= LinkPager::widget([
                'pagination' => $pagination,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'pagination',
                ],
                'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'active'],
                'disableCurrentPageButton' => true,
                'maxButtonCount' => 5,
                'prevPageLabel' => false,
                'nextPageLabel' => 'дальше',
                'hideOnSinglePage' => true
            ]); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

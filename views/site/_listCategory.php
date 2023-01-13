<?php

use yii\helpers\Url;

$categoryIcon = [
    '/img/cat@2x.jpg',
    '/img/cat02@2x.jpg',
    '/img/cat03@2x.jpg',
    '/img/cat04@2x.jpg',
    '/img/cat05@2x.jpg',
    '/img/cat06@2x.jpg',
];

?>

<li class="categories-list__item">
    <a href="<?= Url::toRoute(['offers/category/', 'id' => $model->id ]); ?>"
       class="category-tile category-tile--default">
          <span class="category-tile__image">
            <img src="../../<?= $categoryIcon[array_rand($categoryIcon)]; ?>" alt="Иконка категории">
          </span>
        <span class="category-tile__label"><?= $model->name; ?> <span class="
        category-tile__qty js-qty"><?= count($model->adsToCategories); ?></span></span>
    </a>
</li>

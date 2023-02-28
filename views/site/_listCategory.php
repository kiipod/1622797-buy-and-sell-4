<?php

use yii\helpers\Url;

$categoryIcon = Yii::$app->params['categorySrc'][array_rand(Yii::$app->params['categorySrc'])];

?>

<li class="categories-list__item">
    <a href="<?= Url::toRoute(['offers/category/', 'id' => $model->id ]); ?>"
       class="category-tile category-tile--default">
          <span class="category-tile__image">
            <img src="../../<?= $categoryIcon; ?>" alt="Иконка категории">
          </span>
        <span class="category-tile__label"><?= $model->name; ?> <span class="
        category-tile__qty js-qty"><?= count($model->adsToCategories); ?></span></span>
    </a>
</li>

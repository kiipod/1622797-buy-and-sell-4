<?php

use yii\helpers\Url;

?>

<li class="categories-list__item">
    <a href="<?= Url::to(['offers/category/', 'id' => $model->id ]); ?>"
       class="category-tile category-tile--default">
          <span class="category-tile__image">
            <img src="<?= Yii::getAlias('@web/img/') . $model->icon; ?>.jpg"
                 srcset="<?= Yii::getAlias('@web/img/') . $model->icon; ?>@2x.jpg 2x"
                 alt="Иконка категории">
          </span>
        <span class="category-tile__label"><?= $model->name; ?> <span class="
        category-tile__qty js-qty"><?= count($model->adsToCategories); ?></span></span>
    </a>
</li>

<?php

/** @var yii\web\View $this
 * @var string $value
 * @var array $searchedAds
 * @var object $newAds
 */

use yii\helpers\Html;
use yii\widgets\ListView;

?>

<section class="search-results">
    <h1 class="visually-hidden">Результаты поиска</h1>
    <div class="search-results__wrapper">
        <?php if ($searchedAds->totalCount === 0) : ?>
            <div class="search-results__message">
                <p>Не найдено <br>ни&nbsp;одной публикации</p>
            </div>
        <?php else : ?>
        <p class="search-results__label">
                <?= $searchedAds->totalCount !== 1 ? 'Найдено ' : 'Найдена '; ?>
                <span class="js-results"><?= Html::encode($searchedAds->totalCount); ?>
                    <?= $searchedAds->totalCount !== 1 ? 'публикации' : 'публикация'; ?>
                </span>
        </p>
            <?= ListView::widget([
                'dataProvider' => $searchedAds,
                'itemView' => '../site/_listAds',
                'layout' => "<ul class='search-results__list'>{items}</ul>",
                'itemOptions' => ['tag' => false]
            ]);
            ?>
        <?php endif; ?>
    </div>
</section>
<?php if ($newAds->getCount() > 0) : ?>
<section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <p class="tickets-list__title">Самое свежее</p>
        </div>
        <?= ListView::widget([
            'dataProvider' => $newAds,
            'itemView' => '../site/_listAds',
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

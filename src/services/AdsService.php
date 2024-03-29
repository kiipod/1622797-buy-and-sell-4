<?php

namespace buyandsell\services;

use app\models\AdCategories;
use app\models\Ads;
use app\models\Comments;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;

class AdsService
{
    /** Метод выводит количество объявлений по каждой категории
     *
     * @return ActiveDataProvider
     */
    public function getCategoriesAds(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => AdCategories::find()->joinWith('adsToCategories')
                ->groupBy('categoryId')->having('COUNT(adsToCategories.categoryId) > 0')
        ]);
    }

    /** Метод выводит новые объявления в количестве 8 штук
     *
     * @return ActiveDataProvider
     */
    public function getNewAds(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Ads::find(),
            'pagination' => [
                'pageSize' => 8,
                'pageSizeParam' => false
            ],
            'sort' => [
                'defaultOrder' => [
                    'dateCreation' => SORT_DESC,
                ]
            ]
        ]);
    }

    /** Метод выводит самые комментируемые объявления в количестве 8 штук
     *
     * @return ActiveDataProvider
     */
    public function getCommentedAds(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Comments::find()->groupBy('adId')
                ->having('COUNT(text) > 0')->orderBy('COUNT(text) DESC'),
            'pagination' => [
                'pageSize' => 8,
                'pageSizeParam' => false
            ]
        ]);
    }

    /** Метод получает объявления заданной категории
     *
     * @param int $id
     * @return ActiveDataProvider
     */
    public function getAdsToCategories(int $id): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Ads::find()->joinWith('adsToCategories')
                ->where(['categoryId' => $id]),
            'pagination' => [
                'pageSize' => 8,
                'pageSizeParam' => false
            ],
            'sort' => [
                'defaultOrder' => [
                    'dateCreation' => SORT_DESC,
                ]
            ]
        ]);
    }

    /** Метод подсчитывает количество объявлений для пагинации
     *
     * @param int $categoryId
     * @return ActiveQuery
     */
    public function getCategoryAdsToPagination(int $categoryId): ActiveQuery
    {
        return Ads::find()
            ->joinWith('adsToCategories')
            ->where(['categoryId' => $categoryId]);
    }

    /** Метод удаляет объявление и все комментарии к нему
     *
     * @param Ads $ads
     * @return true
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function deleteAds(ActiveRecord $ads): bool
    {
        $comments = $ads->comments;

        foreach ($comments as $comment) {
            $comment->delete();
        }

        $ads->delete();

        if (!$ads->delete()) {
            return false;
        }
        return true;
    }

    /** Метод осуществляет полнотекстовый поиск по названию объявлений
     *
     * @param string $query
     * @return ActiveDataProvider
     */
    public function getSearchedAds(string $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Ads::find()->where("MATCH(name) AGAINST('{$query}')"),
            'sort' => [
                'defaultOrder' => [
                    'dateCreation' => SORT_DESC
                ]
            ]
        ]);
    }
}

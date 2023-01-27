<?php

namespace buyandsell\services;

use app\models\AdCategories;
use app\models\Ads;
use app\models\Comments;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

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

    /**
     * @param int $categoryId
     * @return ActiveQuery
     */
    public function getCategoryAdsToPagination(int $categoryId): ActiveQuery
    {
        return Ads::find()
            ->joinWith('adsToCategories')
            ->where(['categoryId' => $categoryId]);
    }
}

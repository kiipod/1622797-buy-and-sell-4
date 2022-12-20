<?php

namespace app\controllers;

use yii\web\Controller;
use buyandsell\services\AdsService;

class SiteController extends Controller
{
    /** Метод выводит ошибку на странице
     *
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /** Метод выводит главную страницу сайта и объявления
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $adsServices = new AdsService();

        $newAds = $adsServices->getNewAds();
        $commentedAds = $adsServices->getCommentedAds();
        $categoryAds = $adsServices->getCategoriesAds();

        return $this->render('index', [
            'newAds' => $newAds,
            'commentedAds' => $commentedAds,
            'categoryAds' => $categoryAds
        ]);
    }
}

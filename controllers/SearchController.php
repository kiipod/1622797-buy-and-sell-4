<?php

namespace app\controllers;

use app\models\forms\SearchForm;
use buyandsell\services\AdsService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SearchController extends Controller
{
    public function actionIndex(): Response|string
    {
        $searchForm = new SearchForm();
        $adsService = new AdsService();

        if (Yii::$app->request->getIsGet()) {
            $search = Yii::$app->request->get();
            $searchForm->load($search);
            $searchValue = $searchForm->search;

            if ($searchForm->validate()) {
                $searchedAds = $adsService->getSearchedAds($searchValue);
                $newAds = $adsService->getNewAds();

                return $this->render('index', [
                    'searchValue' => $searchValue,
                    'searchedAds' => $searchedAds,
                    'newAds' => $newAds
                ]);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}

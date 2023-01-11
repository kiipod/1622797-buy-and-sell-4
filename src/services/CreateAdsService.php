<?php

namespace buyandsell\services;

use app\models\Ads;
use app\models\AdsToCategories;
use app\models\forms\OfferForm;
use yii\web\ServerErrorHttpException;

class CreateAdsService
{
    /** Метод сохраняет новое объявление в БД
     *
     * @param OfferForm $form
     * @param $author
     * @return bool
     * @throws ServerErrorHttpException
     */
    public function createAds(OfferForm $form, $author): bool
    {
        $newAds = new Ads();
        $fileService = new FilesService();

        $newAds->name = $form->name;
        $newAds->imageSrc = $fileService->uploadFile($form->image, 'images');
        $newAds->typeId = $form->typeId;
        $newAds->description = $form->description;
        $newAds->author = $author;
        $newAds->price = $form->price;

        if ($newAds->save()) {
            foreach ($form->categories as $category) {
                $newAdsCategory = new AdsToCategories();
                $newAdsCategory->adId = $newAds->id;
                $newAdsCategory->categoryId = $category;
                $newAdsCategory->save();
            }
        }
        return $newAds->save();
    }
}

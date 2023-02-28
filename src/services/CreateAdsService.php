<?php

namespace buyandsell\services;

use app\models\Ads;
use app\models\AdsToCategories;
use app\models\forms\OfferForm;
use Yii;
use yii\db\Exception;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

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

    /** Метод заполняет поля редактирования объявлениями данными из БД
     *
     * @param OfferForm $form
     * @param $currentAds
     * @return void
     */
    public function autocompleteForm(OfferForm $form, $currentAds): void
    {
        if ($currentAds->imageSrc) {
            $form->image = $currentAds->imageSrc;
        }

        $form->name = $currentAds->name;
        $form->typeId = $currentAds->typeId;
        $form->categories = AdsToCategories::find()->select('categoryId')
            ->where(['adId' => $currentAds->id])->column();
        $form->description = $currentAds->description;
        $form->price = $currentAds->price;
    }

    /**
     * @param $currentAds
     * @param OfferForm $form
     * @param $author
     * @return mixed
     * @throws ServerErrorHttpException
     */
    public function editAds($currentAds, OfferForm $form, $author): mixed
    {
        $fileService = new FilesService();

        if ($currentAds->imageSrc) {
            $fileService->deleteFile($currentAds->imageSrc);
        }

        $currentAds->imageSrc = $fileService->uploadFile($form->image, 'images');
        $currentAds->name = $form->name;
        $currentAds->typeId = $form->typeId;
        $currentAds->description = $form->description;
        $currentAds->author = $author;
        $currentAds->price = $form->price;

        if ($currentAds->update()) {
            foreach ($form->categories as $category) {
                $newAdsCategory = new AdsToCategories();
                $newAdsCategory->adId = $currentAds->id;
                $newAdsCategory->categoryId = $category;
                $newAdsCategory->save();
            }
        }
        return $currentAds->update();
    }

    /** Метод удаляет категории объявления
     *
     * @param $adsId
     * @return void
     * @throws Exception
     */
    public function deleteAdsToCategories($adsId): void
    {
        Yii::$app->db->createCommand()->delete('adsToCategories', ['adId' => $adsId])->query();
    }
}

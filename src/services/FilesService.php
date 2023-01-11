<?php

namespace buyandsell\services;

use yii\web\ServerErrorHttpException;

class FilesService
{
    /** Метод сохраняет файлы в папку Uploads
     *
     * @param object $file
     * @param string $folder
     * @return object
     * @throws ServerErrorHttpException
     */
    public function uploadFile(object $file, string $folder): string
    {
        $nameFile = uniqid() . '.' . $file->getExtension();

        if (!$file->saveAs("@webroot/uploads/{$folder}/" . $nameFile)) {
            throw new ServerErrorHttpException('Файл не удалось загрузить');
        }

        return $nameFile;
    }
}

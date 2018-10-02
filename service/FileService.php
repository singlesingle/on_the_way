<?php

namespace app\service;

use app\classes\Util;
use app\classes\Log;
use app\models\DocumentDao;
use Qcloud\Cos\Client;
use Yii;

class FileService
{
    public function uploadFile($documentId, $filePath, $fileName) {
        $appId = Yii::$app->params['app_id'];
        $secretId = Yii::$app->params['secret_id'];
        $secretKey = Yii::$app->params['secret_key'];
        $region = Yii::$app->params['region'];
        $bucket = Yii::$app->params['bucket_name'];
        $key = 'liuxue/' . date('Ymd') . '/' . $fileName;

        $cosClient = new Client((
            array(
                'region' => $region,
                'credentials'=> array(
                    'appId' => $appId,
                    'secretId'  => $secretId,
                    'secretKey' => $secretKey)))
        );

        ### 上传文件流
        try {
            $result = $cosClient->Upload($bucket, $key, fopen($filePath, 'rb'));
            Log::extApiLog('upload_ret', serialize($result), 'tx_cloud');
        } catch (\Exception $e) {
            Log::extApiLog('upload_exception', serialize($e), 'tx_cloud');
            return false;
        }
        $fileUrl = '';
        $documentDao = new DocumentDao();
        $ret = $documentDao->updateFileUrl($fileUrl, $documentId);
        return $ret;
    }
}

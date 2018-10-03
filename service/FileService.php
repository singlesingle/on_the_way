<?php

namespace app\service;

use app\classes\Util;
use app\classes\Log;
use app\models\DocumentDao;
require(__DIR__ . '/../vendor/cos-php-sdk-v5/vendor/autoload.php');
use Qcloud\Cos\Client;
use Yii;

class FileService
{
    public function uploadDocument($documentId, $filePath, $fileName) {
        $fileUrl = self::uploadFile($filePath, $fileName);
        if ($fileUrl === false) {
            return false;
        }else {
            $documentDao = new DocumentDao();
            $ret = $documentDao->updateFileUrl($fileUrl, $documentId);
            return $ret;
        }
    }

    public function uploadFile($filePath, $fileName) {
        $appId = Yii::$app->params['tx_cloud']['app_id'];
        $secretId = Yii::$app->params['tx_cloud']['secret_id'];
        $secretKey = Yii::$app->params['tx_cloud']['secret_key'];
        $region = Yii::$app->params['tx_cloud']['region'];
        $bucket = Yii::$app->params['tx_cloud']['bucket_name'];
        $key = $fileName;

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
            Log::extApiLog('upload_exception', $e->getMessage(), 'tx_cloud');
            return false;
        }
        $fileUrl = $result['Location'];
        return $fileUrl;
    }
}

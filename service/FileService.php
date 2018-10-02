<?php

namespace app\service;

use app\classes\Util;
use app\classes\Log;
use app\models\UserDao;
use Yii;
use linslin\yii2\curl\Curl;
require 'cos-sdk-v5.phar';

class FileService
{
    public function uploadFile($filePath, $fileName) {
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
            return $result;
        } catch (\Exception $e) {
            Log::extApiLog('upload_exception', serialize($e), 'tx_cloud');
            return false;
        }
//
//        ## Upload(高级上传接口，默认使用分块上传最大支持50T)
//        ### 上传内存中的字符串
//        try {
//            $result = $cosClient->Upload($bucket, $key, $body = $file);
//            print_r($result);
//        } catch (\Exception $e) {
//            echo "$e\n";
//        }
    }
}

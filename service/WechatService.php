<?php

namespace app\service;

use app\classes\Util;
use app\classes\Log;
use app\models\UserDao;
use Yii;
use linslin\yii2\curl\Curl;

class WechatService
{
    public $responseCode;

    //获取accessToken
    public function getToken()
    {
        $appId = Yii::$app->params['wechat']['app_id'];
        $appSecret = Yii::$app->params['wechat']['app_secret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appId}&secret={$appSecret}";
        $curl = new Curl();
        $response = $curl->get($url);
        $ret = json_decode($response, true);
        Log::extApiLog('request', $response, 'wechat');
        return $ret['access_token'];
    }

    //获取用户基本信息
    public function getUserInfo($openId, $accessToken)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accessToken}&openid={$openId}&lang=zh_CN";
        $curl = new Curl();
        $response = $curl->get($url);
        $ret = json_decode($response, true);
        Log::extApiLog('request', $response, 'wechat');
        return $ret;
    }
}

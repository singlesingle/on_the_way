<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Log;
use app\classes\Util;
use app\models\CustomerDao;
use app\models\StatusChangeDao;
use app\models\UserDao;
use app\service\CaseService;
use app\service\CustomerService;
use app\service\SchoolService;
use app\service\UserService;
use app\service\WechatService;
use Yii;

class WxController extends BaseController
{
    //微信自动回复
    public function actionReply()
    {
        if ($this->method == "GET") {
            $echostr = $this->getParam('echostr', '');
            echo $echostr;
            die;
        }else {
            Log::addLogNode('post data', serialize($_POST));
//            $xmlData = $GLOBALS['HTTP_RAW_POST_DATA'];
            $xmlData = file_get_contents('php://input');
            $postObj = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);
            Log::addLogNode('MsgType', $postObj->MsgType);
            Log::addLogNode('Content', $postObj->Content);
            if ($postObj->Content != '进度') {
                $msg = "回复下列内容，获取相关信息\n";
                $msg .= "回复【进度】，查询留学办理进度";
            } else {
                $wechatService = new WechatService();
                $accessToken = $wechatService->getToken();
                $openId = $postObj->FromUserName;
                $userInfo = $wechatService->getUserInfo($openId, $accessToken);
                $nickName = $userInfo['nickname']; //用户的昵称
                $customerService = new CustomerService();
                $customerInfo = $customerService->queryByWechat($nickName);
                if (!$customerInfo) {
                    $msg = "您好：\n" . "您不存在处理中的任务！";
                }else {
                    $msg = "{$customerInfo['name']}您好：\n";
                    $customerId = $customerInfo['id'];
                    //收集材料阶段
                    $msg .= "1、收集材料阶段：{$customerInfo['collect_status']}\n";

                    //学校申请阶段
                    $schoolService = new SchoolService();
                    $schoolList = $schoolService->schoolList($customerId);
                    $msg .= "2、学校申请阶段：\n";
                    $i = 1;
                    if ($schoolList) {
                        foreach ($schoolList as $school) {
                            $schoolName = $school['school_name'];
                            $status = $school['status'];
                            $fileUrl = $school['file_url'];
                            $msg .= "{$i}）{$schoolName}，{$status}，附件：{$fileUrl}\n";
                            $i++;
                        }
                    }else {
                        $msg .= "无";
                    }

                    //签证申请阶段
                    $msg .= "3、签证申请阶段：{$customerInfo['visa_status']}";
                    if ($customerInfo['visa_status'] == '签证递交' || $customerInfo['visa_status'] == '获签'
                    || $customerInfo['visa_status'] == '拒签')
                    {
                        $statusChangeDao = new StatusChangeDao();
                        $statusInfo = $statusChangeDao->queryChangeInfo($customerId, 0,
                            StatusChangeDao::$typeToName['签证状态'], CustomerDao::$visaStatusDict[$customerInfo['visa_status']]);
                        if ($statusInfo)
                            $fileUrl = $statusInfo['file_url'];
                        else
                            $fileUrl = '无';
                        $msg .= "，附件：{$fileUrl}\n";
                    }
                }
            }
            $content = $this->_response_text($postObj, $msg);
            echo $content;
        }
    }

    function _response_text($object,$content){
        $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>%d</FuncFlag>
                </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }

}
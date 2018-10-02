<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Log;
use app\classes\Util;
use app\models\UserDao;
use app\service\CaseService;
use app\service\CustomerService;
use app\service\UserService;
use app\service\WechatService;
use Yii;

class WxController extends BaseController
{
    //创建案例
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
            if ($postObj->Content != '进度')
                echo 'success';
            $wechatService = new WechatService();
            $accessToken = $wechatService->getToken();
            $openId = $postObj->ToUserName;
            $userInfo = $wechatService->getUserInfo($openId, $accessToken);
            $nickName = $userInfo['nickname']; //用户的昵称
            $customerService = new CustomerService();
            $customerInfo = $customerService->queryByWechat($nickName);
            if (!$customerInfo) {
                $msg = "您好：\n" . "您不存在处理中的任务！";
            }else {
                $msg = "您好：\n" . "您的申请状态为正在申请中";
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

    //更新案例
    public function actionUpdate()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'case_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'title' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'admission_school' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'rank' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'profession' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'result' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'entry_time' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'graduated_school' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'summary' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $caseId = $this->getParam('case_id', '');
        $title = $this->getParam('title', '');
        $admissionSchool = $this->getParam('admission_school', '');
        $rank = $this->getParam('rank', '');
        $profession = $this->getParam('profession', '');
        $result = $this->getParam('result', '');
        $entryTime = $this->getParam('entry_time', '');
        $graduatedSchool = $this->getParam('graduated_school', '');
        $summary = $this->getParam('summary', '');
        $userId = $this->data['user_id'];
        $caseService = new CaseService();
        $caseInfo = $caseService->queryCase($caseId);
        if (!$caseInfo || $caseInfo['create_user_id'] != $userId) {
            $error = ErrorDict::getError(ErrorDict::G_PARAM, '', '查询案件信息失败！');
            $ret = $this->outputJson('', $error);
            return $ret;
        }
        $ret = $caseService->updateCase($caseId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
        $this->actionLog(self::LOGMOD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //删除案例
    public function actionDeletecase()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'id' => array (
                'require' => true,
                'checker' => 'noCheck',
            )
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $caseId = $this->getParam('id', '');
        $caseService = new CaseService();
        $ret = $caseService->deleteCase($caseId);
        $this->actionLog(self::LOGDEL, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }
}
<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Util;
use app\service\CaseService;
use app\service\MessageService;
use Yii;

class MessageController extends BaseController
{
    //创建系统消息
    public function actionAdd()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'title' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'content' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $title = $this->getParam('title', '');
        $content = $this->getParam('content', '');
        $userId = $this->data['user_id'];
        $messageService = new MessageService();
        $ret = $messageService->add($title, $content, $userId);
        $this->actionLog(self::LOGADD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //发布系统消息
    public function actionRelease()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'message_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $messageId = $this->getParam('message_id', '');
        $messageService = new MessageService();
        $ret = $messageService->release($messageId);
        $this->actionLog(self::LOGADD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //删除系统消息
    public function actionDelete()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'message_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $messageId = $this->getParam('message_id', '');
        $messageService = new MessageService();
        $ret = $messageService->delete($messageId);
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

    //我的消息列表
    public function actionMylist()
    {
        $this->defineMethod = 'POST';

        $this->defineParams = array (
            'aoData' => array(
                'require' => true,
                'checker' => 'noCheck',
            ),
            'page' => array(
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $aoData = $this->getParam('aoData', '');
        $page = $this->getParam('page');
        $iDisplayStart = 0; // 起始索引
        $iDisplayLength = 10;//分页长度
        $json = json_decode($aoData) ;
        foreach($json as $value){
            if($value->name == "sEcho"){
                $sEcho = $value->value;
            }
            if($value->name == "iDisplayStart"){
                $iDisplayStart = $value->value;
            }
            if($value->name == "iDisplayLength"){
                $iDisplayLength = $value->value;
            }
        }
        $userId = $this->data['user_id'];
        $messageService = new MessageService();
        $list = $messageService->myMessage($userId, $iDisplayStart, $iDisplayLength);
        $count = count($list);
        $messageList = [];
        foreach ($list as $one) {
            $data = [];
            $one['create_time'] = date('Y年m月d日 H:i', strtotime($one['create_time']));
            $one['title'] = htmlentities($one['title']);
            $one['create_time'] = htmlentities($one['create_time']);
            $one['content'] = htmlentities($one['content']);
            $data[] = "<a data-toggle=\"modal\" data-target=\"#message_info\" type='button' onclick='messageInfo()' class='text-left'>{$one['title']}</a>
            <a data-toggle=\"modal\" data-target=\"#message_info\" onclick='messageInfo()' class='pull-right' style='color: #9b9b9b'>{$one['create_time']}</a>";
            $messageList[] = $data;
        }
        $json_data = array ('sEcho'=>$sEcho,'iTotalRecords'=>$count,'iTotalDisplayRecords'=>$count,'aaData'=>$messageList);  //按照datatable的当前页和每页长度返回json数据
        $obj=json_encode($json_data, JSON_UNESCAPED_UNICODE);
        echo $obj;
    }

    //查看系统消息
    public function actionInfo()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'message_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $messageId = $this->getParam('message_id', '');
        $userId = $this->data['user_id'];
        $messageService = new MessageService();
        $messageInfo = $messageService->look($messageId, $userId);
        if ($messageInfo) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson($messageInfo, $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }
}
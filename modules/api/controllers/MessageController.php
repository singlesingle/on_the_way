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
    //发布系统消息
    public function actionRelease()
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
        $ret = $messageService->release($title, $content, $userId);
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

    //我的消息列表
    public function actionMylist()
    {
        $this->defineMethod = 'POST';
        $userId = $this->data['user_id'];
        $messageService = new MessageService();
        $ret = $messageService->deleteCase($caseId);
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
<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\models\UserDao;
use app\service\MessageService;
use app\service\UserService;

class MessageController extends BaseController
{

    //系统消息列表
    public function actionList()
    {
        $this->defineMethod = 'GET';
        $messageService = new MessageService();
        $list = $messageService->systemMessageList();
        $this->data['list'] = $list;
        return $this->render('list.tpl', $this->data);
    }
    
}
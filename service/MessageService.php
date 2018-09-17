<?php

namespace app\service;

use app\classes\Log;
use app\models\CaseDao;
use app\models\MessageDao;
use app\models\MessageSenderDao;
use app\models\UserDao;

class MessageService
{
    //发布消息
    public function release($title, $content, $userId)
    {
        $messageDao = new MessageDao();
        $messageSenderDao = new MessageSenderDao();
        //todo增加事务机制
        $messageId = $messageDao->addMessage(MessageDao::$type['系统消息'], $title, $content, $userId);
        $userDao = new UserDao();
        $userList = $userDao->userList();
        foreach ($userList as $user) {
            $messageSenderDao->addMessageSender($messageId, $user['id']);
        }
        return true;
    }

    //系统消息列表
    public function systemMessageList()
    {
        $messageDao = new MessageDao();
        $list = $messageDao->systemMessageList();
        return $list;
    }

    //我的消息列表
    public function myMessage($userId)
    {
        $messageSenderDao = new MessageSenderDao();
    }

    //内部案例列表
    public function innerList()
    {
        $caseDao = new CaseDao();
        $caseList = $caseDao->queryAllCase();
        return $caseList;
    }

    //删除案例
    public function deleteCase($id)
    {
        $caseDao = new CaseDao();
        $deleteRet = $caseDao->deleteCase($id);
        return $deleteRet;
    }
}
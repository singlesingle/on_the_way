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
    public function add($title, $content, $userId)
    {
        $messageDao = new MessageDao();
        $ret = $messageDao->addMessage(MessageDao::$type['系统消息'], $title, $content, $userId);
        return $ret;
    }

    //发布消息
    public function release($id)
    {
        $messageDao = new MessageDao();
        $info = $messageDao->queryById($id);
        //todo 增加事务
        if ($info && $info['status'] == MessageDao::$status['未发布'] && $info['type'] == MessageDao::$type['系统消息']) {
            $userDao = new UserDao();
            $messageSenderDao = new MessageSenderDao();
            $userList = $userDao->userList();
            foreach ($userList as $user) {
                $messageSenderDao->addMessageSender($id, $user['id']);
            }
            $ret = $messageDao->updateStatusById($id, MessageDao::$status['发布']);
            if ($ret)
                return true;
            else
                return false;
        }else
            return false;
    }

    //删除消息
    public function delete($id)
    {
        $messageDao = new MessageDao();
        $ret = $messageDao->deleteById($id);
        return $ret;
    }

    //查看消息
    public function look($messageId, $userId)
    {
        $messageDao = new MessageDao();
        $messageInfo = $messageDao->queryById($messageId);
        $messageSenderDao = new MessageSenderDao();
        $messageSenderDao->updateRead($messageId, $userId);
        return $messageInfo;
    }


    //系统消息列表
    public function systemMessageList()
    {
        $messageDao = new MessageDao();
        $list = $messageDao->systemMessageList();
        foreach ($list as &$one) {
            if ($one['status'] == MessageDao::$status['发布'])
                $one['status'] = '是';
            else
                $one['status'] = '否';
        }
        return $list;
    }

    //我的消息列表
    public function myMessage($userId, $iDisplayStart, $iDisplayLength)
    {
        $messageSenderDao = new MessageSenderDao();
        $messageList = $messageSenderDao->queryUserMessageList($userId, $iDisplayStart, $iDisplayLength);
        return $messageList;
    }

    //未读消息列表
    public function unReadMessage($userId)
    {
        $messageSenderDao = new MessageSenderDao();
        $messageList = $messageSenderDao->queryUnreadMessage($userId);
        return $messageList;
    }
}
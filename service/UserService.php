<?php

namespace app\service;

use app\classes\Log;
use app\models\UserDao;
use Yii;
use linslin\yii2\curl\Curl;

class UserService
{
    public $responseCode;

    //用户列表
    public function userList()
    {
        $userDao = new UserDao();
        $userList = $userDao->userList();
        $managerList = [];
        foreach ($userList as $user) {
            if ($user['role'] == UserDao::$role['总监']) {
                $managerList[$user['id']] = $user;
            }
        }
        foreach ($userList as &$user) {
            unset($user['pwd']);
            if ($user['status'] == UserDao::$status['禁用']) {
                $user['status'] = '禁用';
            }else {
                $user['status'] = '正常';
            }
            if ($user['role'] == UserDao::$role['文案人员']) {
                $user['leader'] = isset($managerList[$userp['id']]) ? $managerList[$user['id']]['name'] : '未知';
            }
        }
        return $userList;
    }

    //创建用户
    public function addUser($name, $phone, $role)
    {
        $userDao = new UserDao();
        $ret = $userDao->addUser(0, $name, $role, $phone, $phone, '');
        return $ret;
    }

    //删除用户
    public function deleteUser($userId)
    {
        $userDao = new UserDao();
        $ret = $userDao->deleteUser($userId);
        return $ret;
    }

    //禁用用户
    public function disableUser($userId)
    {
        $userDao = new UserDao();
        $ret = $userDao->disableUser($userId);
        return $ret;
    }

    //启用用户
    public function enableUser($userId)
    {
        $userDao = new UserDao();
        $ret = $userDao->enableUser($userId);
        return $ret;
    }

    //用户转岗
    public function transferUser($userId, $leaderUserId)
    {
        $userDao = new UserDao();
        $leader = $userDao->queryById($leaderUserId);
        if (!$leader) {
            return false;
        }
        $ret = $userDao->transferUser($userId, $leaderUserId);
        return $ret;
    }

    //查询用户信息
    public function userInfo($phone)
    {
        $userDao = new UserDao();
        $userInfo = $userDao->queryByPhone($phone);
        return $userInfo;
    }

    //累计用户密码错误次数
    public function countError($id)
    {
        $userDao = new UserDao();
        $ret = $userDao->countError($id);
        return $ret;
    }
}
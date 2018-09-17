<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\models\UserDao;
use app\service\UserService;

class UserController extends BaseController
{

    //用户登陆
    public function actionLogin()
    {
        return $this->render('login.tpl', $this->data);
    }

    //用户列表
    public function actionList()
    {
        $this->defineMethod = 'GET';
        $role = $this->data['role'];
        if ($role != UserDao::$role['管理员']) {
            $this->redirect('error/403.tpl');
        }
        $userService = new UserService();
        $userList = $userService->userList();
        $this->data['page_topo'] = 'user_admin';
        $this->data['active_page'] = 'list';
        $this->data['user_list'] = $userList;
        return $this->render('list.tpl', $this->data);
    }
    
}
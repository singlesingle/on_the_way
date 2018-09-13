<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\service\UserService;

class UserController extends BaseController
{

    /**
     * 业务方登陆
     * @return string
     */
    public function actionLogin()
    {
        $this->data['page_topo'] = 'config_admin';
        $this->data['active_page'] = 'login';
        return $this->render('login.tpl', $this->data);
    }

    //用户列表
    public function actionList()
    {
        $this->defineMethod = 'GET';
        $role = $this->data['role'];
//        if ($role != UserDao::$role['管理员']) {
//            $this->redirect('error/403.tpl');
//        }
        $userService = new UserService();
        $userList = $userService->userList();
        $this->data['page_topo'] = 'user_admin';
        $this->data['active_page'] = 'list';
        $this->data['user_list'] = $userList;
        return $this->render('list.tpl', $this->data);
    }
    
}
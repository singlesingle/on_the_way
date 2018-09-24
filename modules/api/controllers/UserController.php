<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Util;
use app\models\UserDao;
use app\service\UserService;
use Yii;

class UserController extends BaseController
{

    //用户登陆
    public function actionLogin()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'phone' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'pwd' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $phone = $this->getParam('phone', '');
        $pwd = $this->getParam('pwd', '');
        $pwd = Util::gen_pwd($pwd);

        $userService = new UserService();
        $userInfo = $userService->userInfo($phone);
        if (!$userInfo) {
            $error = ErrorDict::getError(ErrorDict::G_PARAM, '', 'sorry, phone or password error.');
            $ret = $this->outputJson('', $error);
            return $ret;
        }
        if ($userInfo['status'] == UserDao::$status['禁用']) {
            $error = ErrorDict::getError(ErrorDict::G_PARAM, '', 'warn, your accout is lock!!!');
            $ret = $this->outputJson('', $error);
            return $ret;
        }
        if ($pwd != $userInfo['pwd']) {
            if ($userInfo['lock_total'] >= 20) {
                $userService->disableUser($userInfo['id']);
            }else {
                $userService->countError($userInfo['id']);
            }
            $error = ErrorDict::getError(ErrorDict::G_PARAM, '', 'sorry, phone or password error.');
            $ret = $this->outputJson('', $error);
            return $ret;
        }
        $_SESSION['is_login'] = true;
        $_SESSION['user_id'] = $userInfo['id'];
        $_SESSION['role'] = $userInfo['role'];
        $_SESSION['name'] = $userInfo['name'];
        $error = ErrorDict::getError(ErrorDict::SUCCESS);
        $ret = $this->outputJson('', $error);
        return $ret;
    }

    //创建用户
    public function actionAdduser()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'phone' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'role' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $name = $this->getParam('name', '');
        $phone = $this->getParam('phone', '');
        $role = $this->getParam('role', UserDao::$role['文案人员']);
        if (!in_array($role, array_values(UserDao::$role))) {
            $error = ErrorDict::getError(ErrorDict::G_PARAM, '参数异常', '参数异常');
            $ret = $this->outputJson('', $error);
            return $ret;
        }

        $userService = new UserService();
        $ret = $userService->addUser($name, $phone, $role);
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

    //删除用户
    public function actionDeleteuser()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'user_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            )
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $userId = $this->getParam('user_id', '');
        $userService = new UserService();
        $ret = $userService->deleteUser($userId);
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

    //禁用用户
    public function actionDisuser()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'user_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            )
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $userId = $this->getParam('user_id', '');
        $userService = new UserService();
        $ret = $userService->disableUser($userId);
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

    //解禁用户
    public function actionEnableuser()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'user_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            )
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $userId = $this->getParam('user_id', '');
        $userService = new UserService();
        $ret = $userService->enableUser($userId);
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

    //调整岗位
    public function actionTransfer()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'user_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'leader_user_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            )
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $userId = $this->getParam('user_id', '');
        $leaderUserId = $this->getParam('leader_user_id', '');
        $userService = new UserService();
        $ret = $userService->transferUser($userId, $leaderUserId);
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

    //总监列表
    public function actionManager() {
        $this->defineMethod = 'GET';
        $userService = new UserService();
        $ret = $userService->managerList();
        $list = [];
        foreach ($ret as $one) {
            $manager = [];
            $manager['id'] = $one['id'];
            $manager['text'] = $one['name'];
            $list[] = $manager;
        }
        $data['results'] = $list;
        $error = ErrorDict::getError(ErrorDict::SUCCESS);
        $ret = $this->outputJson($data, $error);
        return $ret;
    }

    //更新用户信息
    public function actionUpdate()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'user_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'phone' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'introduce' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $userId = $this->getParam('user_id', '');
        $name = $this->getParam('name', '');
        $phone = $this->getParam('phone', '');
        $introduce = $this->getParam('introduce', '');
        $userService = new UserService();
        $ret = $userService->updateUser($userId, $name, $phone, $introduce, '');
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

    //更新密码
    public function actionPwd()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'pwd' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $pwd = $this->getParam('pwd', '');
        $userId = $this->data['user_id'];
        $userService = new UserService();
        $ret = $userService->updateUser($userId, '', '', '', $pwd);
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
}

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
}
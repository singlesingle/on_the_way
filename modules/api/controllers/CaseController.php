<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Util;
use app\models\UserDao;
use app\service\CaseService;
use app\service\UserService;
use Yii;

class CaseController extends BaseController
{
    //创建案例
    public function actionAdd()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'customer_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'title' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'admission_school' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'rank' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'profession' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'result' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'entry_time' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'graduated_school' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'summary' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $customerId = $this->getParam('customer_id', '');
        $title = $this->getParam('title', '');
        $admissionSchool = $this->getParam('admission_school', '');
        $rank = $this->getParam('rank', '');
        $profession = $this->getParam('profession', '');
        $result = $this->getParam('result', '');
        $entryTime = $this->getParam('entry_time', '');
        $graduatedSchool = $this->getParam('graduated_school', '');
        $summary = $this->getParam('summary', '');
        $createUserId = $this->data['user_id'];
        $caseService = new CaseService();
        $ret = $caseService->addCase($customerId, $createUserId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
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

    //更新案例
    public function actionUpdate()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'case_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'title' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'admission_school' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'rank' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'profession' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'result' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'entry_time' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'graduated_school' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'summary' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $caseId = $this->getParam('case_id', '');
        $title = $this->getParam('title', '');
        $admissionSchool = $this->getParam('admission_school', '');
        $rank = $this->getParam('rank', '');
        $profession = $this->getParam('profession', '');
        $result = $this->getParam('result', '');
        $entryTime = $this->getParam('entry_time', '');
        $graduatedSchool = $this->getParam('graduated_school', '');
        $summary = $this->getParam('summary', '');
        $userId = $this->data['user_id'];
        $caseService = new CaseService();
        $caseInfo = $caseService->queryCase($caseId);
        if (!$caseInfo || $caseInfo['create_user_id'] != $userId) {
            $error = ErrorDict::getError(ErrorDict::G_PARAM, '', '查询案件信息失败！');
            $ret = $this->outputJson('', $error);
            return $ret;
        }
        $ret = $caseService->updateCase($caseId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
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

    //删除案例
    public function actionDeletecase()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'id' => array (
                'require' => true,
                'checker' => 'noCheck',
            )
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $caseId = $this->getParam('id', '');
        $caseService = new CaseService();
        $ret = $caseService->deleteCase($caseId);
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
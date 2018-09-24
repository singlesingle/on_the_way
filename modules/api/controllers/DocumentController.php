<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\service\DocumentService;
use app\service\CustomerService;
use Yii;

class DocumentController extends BaseController
{
    //添加文书
    public function actionAdd()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'customer_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_school' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'profession' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'type' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $customerId = $this->getParam('customer_id', '');
        $name = $this->getParam('name', '');
        $applySchool = $this->getParam('apply_school', '');
        $profession = $this->getParam('profession', '');
        $type = $this->getParam('type', 0);
        $userId = $this->data['user_id'];
        $annex = '';
        $documentService = new DocumentService();
        $ret = $documentService->addDocument($customerId, $userId, $name, $applySchool, $profession, $type, $annex);
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

    //客户移动
    public function actionTransfer()
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
        $caseService = new CaseService();
        $ret = $caseService->updateCase($customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
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

    //客户申请转案
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
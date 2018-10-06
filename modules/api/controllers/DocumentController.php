<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\models\DocumentDao;
use app\service\DocumentService;
use app\service\CustomerService;
use app\service\FileService;
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

    //上传文件
    public function actionUpload()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'documentId' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $documentId = $this->getParam('documentId', '');
        $filePath = $_FILES["file"]["tmp_name"];
        $fileName = $_FILES["file"]["name"];
        $fileService = new FileService();
        $ret = $fileService->uploadDocument($documentId, $filePath, $fileName);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //下载文件
    public function actionDownload()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'documentId' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $documentId = $this->getParam('documentId', '');
        $documentService = new DocumentService();
        $fileUrl = $documentService->queryFile($documentId);
        if ($fileUrl === false) {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson($fileUrl, $error);
        }
        return $ret;
    }

    //删除文件
    public function actionDelete()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'documentId' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $documentId = $this->getParam('documentId', '');
        $documentService = new DocumentService();
        $ret = $documentService->delete($documentId);
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
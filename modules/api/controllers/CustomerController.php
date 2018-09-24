<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Util;
use app\models\CustomerDao;
use app\service\CaseService;
use app\service\CustomerService;
use Yii;

class CustomerController extends BaseController
{
    //创建客户
    public function actionAdd()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'contract_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'phone' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_country' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_project' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'service_type' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'go_abroad_year' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'line_business' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'wechat' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $name = $this->getParam('name', '');
        $contractId = $this->getParam('contract_id', '');
        $phone = $this->getParam('phone', '');
        $applyCountry = $this->getParam('apply_country', '');
        $applyProject = $this->getParam('apply_project', 0);
        $serviceType = $this->getParam('service_type', '');
        $goAbroadYear = $this->getParam('go_abroad_year', '');
        $lineBusiness = $this->getParam('line_business', '');
        $wechat = $this->getParam('wechat', '');
        $userId = $this->data['user_id'];
        $customerService = new CustomerService();
        $ret = $customerService->addCustomer($userId, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness, $wechat);
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

    //修改客户信息
    public function actionUpdate()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'contract_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'phone' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_country' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_project' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'service_type' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'go_abroad_year' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'line_business' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'wechat' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'communication' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $id = $this->getParam('id', '');
        $name = $this->getParam('name', '');
        $contractId = $this->getParam('contract_id', '');
        $phone = $this->getParam('phone', '');
        $applyCountry = $this->getParam('apply_country', '');
        $applyProject = $this->getParam('apply_project', 0);
        $serviceType = $this->getParam('service_type', '');
        $goAbroadYear = $this->getParam('go_abroad_year', '');
        $lineBusiness = $this->getParam('line_business', '');
        $wechat = $this->getParam('wechat', '');
        $communication = $this->getParam('communication', '');
        $customerService = new CustomerService();
        $ret = $customerService->updateCustomer($id, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness, $wechat, $communication);
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

    //我的客户列表
    public function actionList() {
        $this->defineMethod = 'GET';
        $this->defineParams = array (
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $userId = $this->data['user_id'];
        $role = $this->data['role'];
        $customerService = new CustomerService();
        $customerList = $customerService->customerList($userId, $role);
        $list = [];
        foreach ($customerList as $customer) {
            $one = [];
            $one['id'] = $customer['id'];
            $one['text'] = $customer['name'] . '：' .$customer['apply_project'];
            $list[] = $one;
        }
        $data['results'] = $list;
        $error = ErrorDict::getError(ErrorDict::SUCCESS);
        $ret = $this->outputJson($data, $error);
        return $ret;
    }
}
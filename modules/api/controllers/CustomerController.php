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
        $wechat = $this->getParam('wechat', '');
        $userId = $this->data['user_id'];
        $customerService = new CustomerService();
        $ret = $customerService->addCustomer($userId, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $wechat);
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

    //查询客户列表
    public function actionSearchlist() {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'apply_country' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'apply_project' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'service_type' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'go_abroad_year' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'apply_status' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'visa_status' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'close_case_status' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'aoData' => array(
                'require' => true,
                'checker' => 'noCheck',
            ),
            'page' => array(
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $applyCountry = $this->getParam('apply_country', '');
        $applyProject = $this->getParam('apply_project', '');
        $serviceType = $this->getParam('service_type', '');
        $goAbroadYear = $this->getParam('go_abroad_year', '');
        $applyStatus = $this->getParam('apply_status', '');
        $visaStatus = $this->getParam('visa_status', '');
        $closeCaseStatus = $this->getParam('close_case_status', '');
        $aoData = $this->getParam('aoData', '');
        $page = $this->getParam('page');
        $iDisplayStart = 0; // 起始索引
        $iDisplayLength = 10;//分页长度
        $json = json_decode($aoData) ;
        foreach($json as $value){
            if($value->name == "sEcho"){
                $sEcho = $value->value;
            }
            if($value->name == "iDisplayStart"){
                $iDisplayStart = $value->value;
            }
            if($value->name == "iDisplayLength"){
                $iDisplayLength = $value->value;
            }
        }
        $userId = $this->data['user_id'];
        $role = $this->data['role'];
        $customerList = array();
        $customerService = new CustomerService();
        $list = $customerService->queryCustomerList($applyCountry, $applyProject, $serviceType, $goAbroadYear,
            $applyStatus, $visaStatus, $closeCaseStatus, $iDisplayStart, $iDisplayLength, $userId, $role);
        if ($list) {
            $count = count($list);
            foreach ($list as $one) {
                $data = [];
                $data[] = $one['name'];
                $data[] = $one['contract_id'];
                $data[] = $one['phone'];
                $data[] = $one['apply_country'];
                $data[] = $one['apply_project'];
                $data[] = $one['service_type'];
                $data[] = $one['go_abroad_year'];
                $data[] = $one['wechat'];
                $data[] = $one['apply_status'];
                $data[] = $one['visa_status'];
                $data[] = $one['close_case_status'];
                $data[] = "<a type=\"button\" class=\"btn btn-sm btn-danger\" href=\"/page/customer/info?id={$one['id']}\">查看</a>";
                $customerList[] = $data;
            }
        }else {
            $customerList = [];
            $count = 0;
        }
        $json_data = array ('sEcho'=>$sEcho,'iTotalRecords'=>$count,'iTotalDisplayRecords'=>$count,'aaData'=>$customerList);  //按照datatable的当前页和每页长度返回json数据
        $obj=json_encode($json_data, JSON_UNESCAPED_UNICODE);
        echo $obj;
    }
}
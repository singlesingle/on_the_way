<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\models\BasicInfoDao;
use app\service\BasicInfoService;
use app\service\CustomerService;
use app\service\EducationService;
use app\service\MaterialService;
use app\service\SchoolService;

class CustomerController extends BaseController
{

    //客户列表
    public function actionList()
    {
        $this->defineMethod = 'GET';
        $userId = $this->data['user_id'];
        $role = $this->data['role'];
        $customerService = new CustomerService();
        $customerList = $customerService->customerList($userId, $role);
        $this->data['page_topo'] = 'customer_admin';
        $this->data['active_page'] = 'list';
        $this->data['customer_list'] = $customerList;
        return $this->render('list.tpl', $this->data);
    }

    //客户详细信息
    public function actionInfo()
    {
        $this->defineMethod = 'GET';
        $this->defineParams = array (
            'id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $id = $this->getParam('id', '');
        $userId = $this->data['user_id'];
        $customerService = new CustomerService();
        $customerInfo = $customerService->customerInfo($id);
        $basicInfoService = new BasicInfoService();
        $basicInfo = $basicInfoService->basicInfo($customerInfo['id']);
        $schoolService = new SchoolService();
        $schoolList = $schoolService->schoolList($customerInfo['id']);
        $materialService = new MaterialService();
        $materialList = $materialService->materialList($customerInfo['id']);
        $educationService = new EducationService();
        $educationInfo = $educationService->educationInfo($customerInfo['id']);
        $this->data['page_topo'] = 'customer_admin';
        $this->data['active_page'] = 'list';
        $this->data['customer_info'] = $customerInfo;
        $this->data['basic_info'] = $basicInfo;
        $this->data['school_list'] = $schoolList;
        $this->data['material_list'] = $materialList;
        $this->data['education'] = $educationInfo;
        return $this->render('info.tpl', $this->data);
    }
    
}
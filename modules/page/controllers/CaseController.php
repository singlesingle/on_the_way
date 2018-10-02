<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\service\CaseService;
use app\service\CustomerService;
use app\service\SchoolService;
use app\service\UserService;

class CaseController extends BaseController
{

    //我的案例
    public function actionMy()
    {
        $this->defineMethod = 'GET';
        $userId = $this->data['user_id'];
        $caseService = new CaseService();
        $caseList = $caseService->myList($userId);
        $this->data['page_topo'] = 'case_admin';
        $this->data['active_page'] = 'my';
        $this->data['case_list'] = $caseList;
        return $this->render('my.tpl', $this->data);
    }

    //内部案例
    public function actionInner()
    {
        $this->defineMethod = 'GET';
        $caseService = new CaseService();
        $caseList = $caseService->innerList();
        $this->data['page_topo'] = 'case_admin';
        $this->data['active_page'] = 'inner';
        $this->data['case_list'] = $caseList;
        return $this->render('inner.tpl', $this->data);
    }

    //案例信息
    public function actionInfo()
    {
        $this->defineMethod = 'GET';
        $caseId = $this->getParam('id', '');
        $caseInfo = [];
        $customerInfo = [];
        $schoolInfo = [];
        if ($caseId) {
            $caseService = new CaseService();
            $caseInfo = $caseService->queryCase($caseId);
            $customerService = new CustomerService();
            $customerInfo = $customerService->customerInfo($caseInfo['customer_id']);
            $schoolService = new SchoolService();
            $schoolInfo = $schoolService->schoolList($caseInfo['customer_id']);
        }
        $this->data['page_topo'] = 'case_admin';
        $this->data['active_page'] = 'inner';
        $this->data['case_info'] = $caseInfo;
        $this->data['customer_info'] = $customerInfo;
        $this->data['school_info'] = $schoolInfo;
        $this->data['is_write'] = false;
        return $this->render('info.tpl', $this->data);
    }
    
}
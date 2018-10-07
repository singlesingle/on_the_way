<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\classes\Log;
use app\service\CaseService;
use app\service\CustomerService;
use app\service\EducationService;
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
        $educationInfo = [];
        if ($caseId) {
            $caseService = new CaseService();
            Log::addLogNode('case_id', $caseId);
            $caseInfo = $caseService->queryCase($caseId);

            Log::addLogNode('case_info', serialize($caseInfo));
            $customerService = new CustomerService();
            $customerInfo = $customerService->customerInfo($caseInfo['customer_id']);
            $schoolService = new SchoolService();
            $schoolInfo = $schoolService->schoolList($caseInfo['customer_id']);
            $educationService = new EducationService();

            Log::addLogNode('customer_id', $caseInfo['customer_id']);
            $educationInfo = $educationService->educationInfo($caseInfo['customer_id']);

            Log::addLogNode('education_info', serialize($educationInfo));
        }
        $this->data['page_topo'] = 'case_admin';
        $this->data['active_page'] = 'inner';
        $this->data['case_info'] = $caseInfo;
        $this->data['customer_info'] = $customerInfo;
        $this->data['school_info'] = $schoolInfo;
        $this->data['education_info'] = $educationInfo;
        $this->data['is_write'] = false;
        return $this->render('info.tpl', $this->data);
    }
    
}
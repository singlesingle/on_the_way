<?php

namespace app\modules\page\controllers;

use app\classes\BaseController;
use app\service\CaseService;
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
    
}
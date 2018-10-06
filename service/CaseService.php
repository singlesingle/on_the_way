<?php

namespace app\service;

use app\classes\Log;
use app\models\CaseDao;
use app\models\CustomerDao;
use app\models\UserDao;

class CaseService
{
    //创建案例
    public function addCase($customerId, $createUserId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary)
    {
        $caseDao = new CaseDao();
        $addRet = $caseDao->addCase($customerId, $createUserId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
        return $addRet;
    }

    //更新案例
    public function updateCase($caseId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary)
    {
        $caseDao = new CaseDao();
        $updateRet = $caseDao->updateCase($caseId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
        return $updateRet;
    }

    //我的案例列表
    public function myList($userId)
    {
        $caseDao = new CaseDao();
        $caseList = $caseDao->queryMyCase($userId);
        foreach ($caseList as &$one) {
            if (isset(CustomerDao::$applyProject[$one['apply_project']]))
                $one['apply_project'] = CustomerDao::$applyProject[$one['apply_project']];
            else
                $one['apply_project'] = '';
//            if (isset(CaseDao::$result[$one['result']]))
//                $one['result'] = CaseDao::$result[$one['result']];
//            else
//                $one['result'] = '';
            if (isset(CustomerDao::$closeCaseStatus[$one['close_case_status']]))
                $one['close_case_status'] = CustomerDao::$closeCaseStatus[$one['close_case_status']];
            else
                $one['close_case_status'] = '';
            if (isset(CustomerDao::$applyCountry[$one['apply_country']]))
                $one['apply_country'] = CustomerDao::$applyCountry[$one['apply_country']];
            else
                $one['apply_country'] = '';
        }
        return $caseList;
    }

    //内部案例列表
    public function innerList()
    {
        $caseDao = new CaseDao();
        $caseList = $caseDao->queryAllCase();
        foreach ($caseList as &$one) {
            if (isset(CustomerDao::$applyProject[$one['apply_project']]))
                $one['apply_project'] = CustomerDao::$applyProject[$one['apply_project']];
            else
                $one['apply_project'] = '';
            if (isset(CaseDao::$result[$one['result']]))
                $one['result'] = CaseDao::$result[$one['result']];
            else
                $one['result'] = '';
            if (isset(CustomerDao::$closeCaseStatus[$one['close_case_status']]))
                $one['close_case_status'] = CustomerDao::$closeCaseStatus[$one['close_case_status']];
            else
                $one['close_case_status'] = '';
            if (isset(CustomerDao::$applyCountry[$one['apply_country']]))
                $one['apply_country'] = CustomerDao::$applyCountry[$one['apply_country']];
            else
                $one['apply_country'] = '';
        }
        return $caseList;
    }

    //删除案例
    public function deleteCase($id)
    {
        $caseDao = new CaseDao();
        $deleteRet = $caseDao->deleteCase($id);
        return $deleteRet;
    }

    //查询案例信息
    public function queryCase($id)
    {
        $caseDao = new CaseDao();
        $caseInfo = $caseDao->queryById($id);
        return $caseInfo;
    }
}
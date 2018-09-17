<?php

namespace app\service;

use app\classes\Log;
use app\models\CaseDao;
use app\models\UserDao;

class CaseService
{
    //创建案例
    public function addCase($customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary)
    {
        $caseDao = new CaseDao();
        $addRet = $caseDao->addCase($customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
        return $addRet;
    }

    //更新案例
    public function updateCase($customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary)
    {
        $caseDao = new CaseDao();
        $updateRet = $caseDao->updateCase($customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary);
        return $updateRet;
    }

    //我的案例列表
    public function myList($userId)
    {
        $caseDao = new CaseDao();
        $caseList = $caseDao->queryMyCase($userId);
        return $caseList;
    }

    //内部案例列表
    public function innerList()
    {
        $caseDao = new CaseDao();
        $caseList = $caseDao->queryAllCase();
        return $caseList;
    }

    //删除案例
    public function deleteCase($id)
    {
        $caseDao = new CaseDao();
        $deleteRet = $caseDao->deleteCase($id);
        return $deleteRet;
    }
}
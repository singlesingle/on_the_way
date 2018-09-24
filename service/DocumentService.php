<?php

namespace app\service;

use app\classes\Log;
use app\models\DocumentDao;
use app\models\CustomerDao;
use app\models\UserDao;

class DocumentService
{
    public function addDocument($customerId, $userId, $name, $applySchool, $profession, $type, $annex) {
        $documentDao = new DocumentDao();
        $ret = $documentDao->addDocument($customerId, $userId, $name, $applySchool, $profession, $type, $annex);
        return $ret;
    }
    //客户列表
    public function documentList($userId)
    {
        $customerDict = [];
        $customerDao = new CustomerDao();
        $customerList = $customerDao->queryAllList();
        foreach ($customerList  as $customer) {
            $customerDict[$customer['id']] = $customer;
        }
        $documentDao = new DocumentDao();
        $documentList = $documentDao->queryAll();
        foreach ($documentList as &$one) {
            if (isset(DocumentDao::$typeDict[$one['type']])) {
                $one['type'] = DocumentDao::$typeDict[$one['type']];
            }else
                $one['type'] = '';
            if ($userId == $one['user_id']) {
                $one['is_my'] = true;
            }else
                $one['is_my'] = false;
            if (isset($customerDict[$one['customer_id']])) {
                $one['student_name'] = $customerDict[$one['customer_id']]['name'];
                $one['apply_country'] = $customerDict[$one['customer_id']]['apply_country'];
                if (isset(CustomerDao::$applyProject[$customerDict[$one['customer_id']]['apply_project']])) {
                    $one['apply_project'] = CustomerDao::$applyProject[$customerDict[$one['customer_id']]['apply_project']];
                }else
                    $one['apply_project'] = '';
            }
        }
        return $documentList;
    }
}
<?php

namespace app\service;

use app\classes\Log;
use app\models\BasicInfoDao;
use app\models\CaseDao;
use app\models\CustomerDao;
use app\models\UserDao;

class CustomerService
{
    public function addCustomer($userId, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $wechat) {
        $customerDao = new CustomerDao();
        $ret = $customerDao->addCustomer($userId, $name, $contractId, $phone, $wechat, $applyCountry,
            $applyProject, $serviceType, $goAbroadYear, CustomerDao::$applyStatusDict['未开始'],
            CustomerDao::$visaStatusDict['待申请'], CustomerDao::$closeCaseStatusDict['未结案']);
        return $ret;
    }

    //客户列表
    public function customerList($userId, $role)
    {
        $list = [];
        $customerDao = new CustomerDao();
        $userDao = new UserDao();
        if ($role == UserDao::$role['管理员']) {
            $list = $customerDao->queryAllList();
        }elseif ($role == UserDao::$role['总监']) {
            $userList = $userDao->queryByLeader($userId);
            $userIds = [];
            foreach ($userList as $user) {
                $userIds[] = $user['id'];
            }
            $list = $customerDao->queryListByUser($userIds);
        }elseif ($role == UserDao::$role['文案人员']) {
            $userIds = [$userId];
            $list = $customerDao->queryListByUser($userIds);
        }
        foreach ($list as &$one) {
            if (isset(CustomerDao::$serviceType[$one['service_type']])) {
                $one['service_type'] = CustomerDao::$serviceType[$one['service_type']];
            }else
                $one['service_type'] = '';
            if (isset(CustomerDao::$applyStatus[$one['apply_status']])) {
                $one['apply_status'] = CustomerDao::$applyStatus[$one['apply_status']];
            }else
                $one['apply_status'] = '';
            if (isset(CustomerDao::$visaStatus[$one['visa_status']])) {
                $one['visa_status'] = CustomerDao::$visaStatus[$one['visa_status']];
            }else
                $one['visa_status'] = '';
            if (isset(CustomerDao::$closeCaseStatus[$one['close_case_status']])) {
                $one['close_case_status'] = CustomerDao::$closeCaseStatus[$one['close_case_status']];
            }else
                $one['close_case_status'] = '';
            if (isset(CustomerDao::$applyProject[$one['apply_project']])) {
                $one['apply_project'] = CustomerDao::$applyProject[$one['apply_project']];
            }else
                $one['apply_project'] = '';
            if (isset(CustomerDao::$applyCountry[$one['apply_country']])) {
                $one['apply_country'] = CustomerDao::$applyCountry[$one['apply_country']];
            }else
                $one['apply_country'] = '';
        }
        return $list;
    }

    public function customerInfo($id) {
        $customerDao = new CustomerDao();
        $one = $customerDao->queryById($id);
        if (isset(CustomerDao::$serviceType[$one['service_type']])) {
            $one['service_type'] = CustomerDao::$serviceType[$one['service_type']];
        }else
            $one['service_type'] = '';
        if (isset(CustomerDao::$applyStatus[$one['apply_status']])) {
            $one['apply_status'] = CustomerDao::$applyStatus[$one['apply_status']];
        }else
            $one['apply_status'] = '';
        if (isset(CustomerDao::$visaStatus[$one['visa_status']])) {
            $one['visa_status'] = CustomerDao::$visaStatus[$one['visa_status']];
        }else
            $one['visa_status'] = '';
        if (isset(CustomerDao::$closeCaseStatus[$one['close_case_status']])) {
            $one['close_case_status'] = CustomerDao::$closeCaseStatus[$one['close_case_status']];
        }else
            $one['close_case_status'] = '';
        if (isset(CustomerDao::$applyProject[$one['apply_project']])) {
            $one['apply_project'] = CustomerDao::$applyProject[$one['apply_project']];
        }else
            $one['apply_project'] = '';
        if (isset(CustomerDao::$applyCountry[$one['apply_country']])) {
            $one['apply_country'] = CustomerDao::$applyCountry[$one['apply_country']];
        }else
            $one['apply_country'] = '';
        return $one;

    }

    //修改客户基本信息
    public function updateCustomer($id, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear,
                                   $lineBusiness, $wechat, $communication) {
        $customerDao = new CustomerDao();
        $ret = $customerDao->updateCustomer($id, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear,
            $lineBusiness, $wechat, $communication);
        return $ret;
    }

    //查询客户列表
    public function queryCustomerList($applyCountry, $applyProject, $serviceType, $goAbroadYear, $applyStatus, $visaStatus,
                                      $closeCaseStatus, $iDisplayStart, $iDisplayLength, $userId, $role)
    {
        $customerDao = new CustomerDao();
        $userDao = new UserDao();
        $userIds = [];
        if ($role == UserDao::$role['管理员']) {
        }elseif ($role == UserDao::$role['总监']) {
            $userList = $userDao->queryByLeader($userId);
            foreach ($userList as $user) {
                $userIds[] = $user['id'];
            }
        }elseif ($role == UserDao::$role['文案人员']) {
            $userIds = [$userId];
        }
        $list = $customerDao->listByCondition($applyCountry, $applyProject, $serviceType, $goAbroadYear, $applyStatus, $visaStatus,
            $closeCaseStatus, $iDisplayStart, $iDisplayLength, $userIds);
        foreach ($list as &$one) {
            if (isset(CustomerDao::$serviceType[$one['service_type']])) {
                $one['service_type'] = CustomerDao::$serviceType[$one['service_type']];
            }else
                $one['service_type'] = '';
            if (isset(CustomerDao::$applyStatus[$one['apply_status']])) {
                $one['apply_status'] = CustomerDao::$applyStatus[$one['apply_status']];
            }else
                $one['apply_status'] = '';
            if (isset(CustomerDao::$visaStatus[$one['visa_status']])) {
                $one['visa_status'] = CustomerDao::$visaStatus[$one['visa_status']];
            }else
                $one['visa_status'] = '';
            if (isset(CustomerDao::$closeCaseStatus[$one['close_case_status']])) {
                $one['close_case_status'] = CustomerDao::$closeCaseStatus[$one['close_case_status']];
            }else
                $one['close_case_status'] = '';
            if (isset(CustomerDao::$applyProject[$one['apply_project']])) {
                $one['apply_project'] = CustomerDao::$applyProject[$one['apply_project']];
            }else
                $one['apply_project'] = '';
            if (isset(CustomerDao::$applyCountry[$one['apply_country']])) {
                $one['apply_country'] = CustomerDao::$applyCountry[$one['apply_country']];
            }else
                $one['apply_country'] = '';
        }
        return $list;
    }
}
<?php

namespace app\service;

use app\classes\Log;
use app\models\CaseDao;
use app\models\CustomerDao;
use app\models\UserDao;

class CustomerService
{
    public function addCustomer($userId, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness, $wechat) {
        $customerDao = new CustomerDao();
        $ret = $customerDao->addCustomer($userId, $name, $contractId, $phone, CustomerDao::$progressDict['已签约'], $wechat, $applyCountry,
            $applyProject, $serviceType, $goAbroadYear, $lineBusiness, CustomerDao::$selectCheckDict['已确认'],
            CustomerDao::$applyStatusDict['申请中'], CustomerDao::$visaStatusDict['待申请'], CustomerDao::$closeCaseStatusDict['未提交'], 0);
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
            if (isset(CustomerDao::$selectCheck[$one['select_check']])) {
                $one['select_check'] = CustomerDao::$selectCheck[$one['select_check']];
            }else
                $one['select_check'] = '';
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
            if (isset(CustomerDao::$closeCaseType[$one['close_case_type']])) {
                $one['close_case_type'] = CustomerDao::$closeCaseType[$one['close_case_type']];
            }else
                $one['close_case_type'] = '';
            if (isset(CustomerDao::$applyProject[$one['apply_project']])) {
                $one['apply_project'] = CustomerDao::$applyProject[$one['apply_project']];
            }else
                $one['apply_project'] = '';
            if (isset(CustomerDao::$bindWechat[$one['bind_wechat']])) {
                $one['bind_wechat'] = CustomerDao::$bindWechat[$one['bind_wechat']];
            }else
                $one['bind_wechat'] = '';
        }
        return $list;
    }

    public function customerInfo($id, $userId) {
        $customerDao = new CustomerDao();
        $userDao = new UserDao();
        $userInfo = $userDao->queryById($userId);
        $userIds = [];
        $power = false;
        if ($userInfo['role'] == UserDao::$role['管理员']) {
            $power = true;
        }elseif ($userInfo['role'] == UserDao::$role['总监']) {
            $userList = $userDao->queryByLeader($userId);
            $userIds = [];
            foreach ($userList as $user) {
                $userIds[] = $user['id'];
            }
        }elseif ($userInfo['role'] == UserDao::$role['文案人员']) {
            $userIds = [$userId];
        }
        if ($power || in_array($userId, $userIds)) {
            $one = $customerDao->queryById($id);
            if (isset(CustomerDao::$serviceType[$one['service_type']])) {
                $one['service_type'] = CustomerDao::$serviceType[$one['service_type']];
            }else
                $one['service_type'] = '';
            if (isset(CustomerDao::$selectCheck[$one['select_check']])) {
                $one['select_check'] = CustomerDao::$selectCheck[$one['select_check']];
            }else
                $one['select_check'] = '';
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
            if (isset(CustomerDao::$closeCaseType[$one['close_case_type']])) {
                $one['close_case_type'] = CustomerDao::$closeCaseType[$one['close_case_type']];
            }else
                $one['close_case_type'] = '';
            if (isset(CustomerDao::$applyProject[$one['apply_project']])) {
                $one['apply_project'] = CustomerDao::$applyProject[$one['apply_project']];
            }else
                $one['apply_project'] = '';
            if (isset(CustomerDao::$bindWechat[$one['bind_wechat']])) {
                $one['bind_wechat'] = CustomerDao::$bindWechat[$one['bind_wechat']];
            }else
                $one['bind_wechat'] = '';
            return $one;
        }else {
            return false;
        }

    }

    //修改客户基本信息
    public function updateCustomer($id, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear,
                                   $lineBusiness, $wechat, $communication) {
        $customerDao = new CustomerDao();
        $ret = $customerDao->updateCustomer($id, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear,
            $lineBusiness, $wechat, $communication);
        return $ret;
    }
}
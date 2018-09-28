<?php

namespace app\service;

use app\classes\Log;
use app\models\BasicInfoDao;
use app\models\CaseDao;
use app\models\CustomerDao;
use app\models\UserDao;

class BasicInfoService
{
    public function addBasicInfo($customerId)
    {
        $basicInfoDao = new BasicInfoDao();
        $ret = $basicInfoDao->addBasicInfo($customerId);
        return $ret;
    }

    public function basicInfo($customerId)
    {
        $basicInfoDao = new BasicInfoDao();
        $basicInfo = $basicInfoDao->queryByCustomerId($customerId);
        if (isset(BasicInfoDao::$gender[$basicInfo['gender']])) {
            $basicInfo['gender'] = BasicInfoDao::$gender[$basicInfo['gender']];
        } else
            $basicInfo['gender'] = '';
        if (isset(BasicInfoDao::$maritalStatus[$basicInfo['marital_status']])) {
            $basicInfo['marital_status'] = BasicInfoDao::$maritalStatus[$basicInfo['marital_status']];
        } else
            $basicInfo['marital_status'] = '';
        return $basicInfo;
    }

    //保存客户基本信息
    public function saveBasicInfo($id, $namePinyin, $englishName, $usedName, $idNumber, $email, $landlineNumber, $address,
                                  $zipCode, $mailAddress, $mailZipCode, $placeBirth, $birthday, $gender, $nativeLanguage, $secondLanguage,
                                  $country, $maritalStatus, $passport, $passportPlace, $passportDate) {
        $basicInfoDao = new BasicInfoDao();
        $ret = $basicInfoDao->updateBasicInfo($id, $namePinyin, $englishName, $usedName, $idNumber, $email, $landlineNumber, $address,
            $zipCode, $mailAddress, $mailZipCode, $placeBirth, $birthday, $gender, $nativeLanguage, $secondLanguage,
            $country, $maritalStatus, $passport, $passportPlace, $passportDate);
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
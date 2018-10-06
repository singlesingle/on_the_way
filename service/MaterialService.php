<?php

namespace app\service;

use app\classes\Log;
use app\models\BasicInfoDao;
use app\models\CaseDao;
use app\models\CustomerDao;
use app\models\MaterialDao;
use app\models\SchoolDao;
use app\models\StatusChangeDao;
use app\models\UserDao;

class MaterialService
{
    public function addMaterial($userId, $customerId, $name, $type, $schoolId, $url)
    {
        if (!isset(MaterialDao::$type[$type])) {
            return false;
        }
        $materialDao = new MaterialDao();
        $ret = $materialDao->addMaterial($customerId, $name, $type, $schoolId, $url);
        $customerDao = new CustomerDao();
        $statusChangeDao = new StatusChangeDao();
        $schoolDao = new SchoolDao();
        if ($type == MaterialDao::$typeToName['签证递交回执']) {
            $customerDao->updateVisaStatus($customerId, CustomerDao::$visaStatusDict['签证递交']);
            $statusChangeDao->addStatusChange($customerId, $userId, StatusChangeDao::$typeToName['签证状态'],
                CustomerDao::$visaStatusDict['签证递交'], $schoolId, $url);

        }elseif ($type == MaterialDao::$typeToName['获签信']) {
            $customerDao->updateVisaStatus($customerId, CustomerDao::$visaStatusDict['获签']);
            $statusChangeDao->addStatusChange($customerId, $userId, StatusChangeDao::$typeToName['签证状态'],
                CustomerDao::$visaStatusDict['获签'], $schoolId, $url);

        }elseif ($type == MaterialDao::$typeToName['拒签信']) {
            $customerDao->updateVisaStatus($customerId, CustomerDao::$visaStatusDict['拒签']);
            $statusChangeDao->addStatusChange($customerId, $userId, StatusChangeDao::$typeToName['签证状态'],
                CustomerDao::$visaStatusDict['拒签'], $schoolId, $url);

        }elseif ($type == MaterialDao::$typeToName['学校申请回执']) {
            $schoolDao->updateApplyStatus($schoolId, SchoolDao::$applyStatusName['已申请']);
            $statusChangeDao->addStatusChange($customerId, $userId, StatusChangeDao::$typeToName['学校申请状态'],
                SchoolDao::$applyStatusName['已申请'], $schoolId, $url);

        }elseif ($type == MaterialDao::$typeToName['offer']) {
            $schoolDao->updateApplyStatus($schoolId, SchoolDao::$applyStatusName['录取']);
            $statusChangeDao->addStatusChange($customerId, $userId, StatusChangeDao::$typeToName['学校申请状态'],
                SchoolDao::$applyStatusName['录取'], $schoolId, $url);

        }elseif ($type == MaterialDao::$typeToName['拒录信']) {
            $schoolDao->updateApplyStatus($schoolId, SchoolDao::$applyStatusName['未录取']);
            $statusChangeDao->addStatusChange($customerId, $userId, StatusChangeDao::$typeToName['学校申请状态'],
                SchoolDao::$applyStatusName['未录取'], $schoolId, $url);
        }
        return $ret;
    }

    public function materialList($customerId)
    {
        $materialDao = new MaterialDao();
        $list = $materialDao->queryByCustomerId($customerId);
        foreach ($list as &$one) {
            if (isset(MaterialDao::$type[$one['type']])) {
                $one['type'] = MaterialDao::$type[$one['type']];
            }
        }
        return $list;
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
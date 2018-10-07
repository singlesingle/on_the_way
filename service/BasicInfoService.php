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
}
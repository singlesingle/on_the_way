<?php

namespace app\service;

use app\classes\Log;
use app\models\EducationDao;

class EducationService
{
    public function addEducation($customerId)
    {
        $educationDao = new EducationDao();
        $ret = $educationDao->addEducationInfo($customerId);
        return $ret;
    }

    public function educationInfo($customerId)
    {
        $educationDao = new EducationDao();
        $educationInfo = $educationDao->queryByCustomerId($customerId);
        return $educationInfo;
    }

    public function saveEducation($id, $startTime, $endTime, $major, $level, $address, $schoolName,
                                  $rank, $type, $schoolWeb, $phone) {
        $educationDao = new EducationDao();
        $ret = $educationDao->updateEducationInfo($id, $startTime, $endTime, $major, $level, $address, $schoolName,
            $rank, $type, $schoolWeb, $phone);
        return $ret;
    }
}
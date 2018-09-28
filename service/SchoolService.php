<?php

namespace app\service;

use app\classes\Log;
use app\models\BasicInfoDao;
use app\models\CaseDao;
use app\models\CustomerDao;
use app\models\ProfessionDao;
use app\models\SchoolDao;
use app\models\UserDao;

class SchoolService
{
    public function addSchool($customerId, $name, $schoolArea, $degree, $admissionTime) {
        $schoolDao = new SchoolDao();
        $ret = $schoolDao->addSchool($customerId, $name, $schoolArea, $degree, $admissionTime);
        return $ret;
    }

    //查询学校列表
    public function schoolList($customerId)
    {
        $schoolDao = new SchoolDao();
        $list = $schoolDao->queryById($customerId);
        foreach ($list as &$one) {
            if (isset(ProfessionDao::$honors[$one['honors']])) {
                $one['honors'] = ProfessionDao::$honors[$one['honors']];
            }else
                $one['honors'] = '';
            if (isset(ProfessionDao::$practice[$one['practice']])) {
                $one['practice'] = ProfessionDao::$practice[$one['practice']];
            }else
                $one['practice'] = '';
            $one['status'] = '待申请';
        }
        return $list;
    }

    public function addProfession($schoolId, $class, $name, $link, $endTime, $endTimeLink, $practice, $honors, $remark) {
        $professionDao = new ProfessionDao();
        $ret = $professionDao->addProfession($schoolId, $class, $name, $link, $endTime, $endTimeLink, $practice, $honors, $remark);
        return $ret;
    }
}
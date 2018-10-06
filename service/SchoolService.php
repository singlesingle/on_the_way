<?php

namespace app\service;

use app\classes\Log;
use app\models\BasicInfoDao;
use app\models\CaseDao;
use app\models\CustomerDao;
use app\models\ProfessionDao;
use app\models\SchoolDao;
use app\models\StatusChangeDao;
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
        $statusChangeDao = new StatusChangeDao();
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
            $changInfo = $statusChangeDao->queryChangeInfo($customerId, $one['id'],
                StatusChangeDao::$typeToName['学校申请状态'], $one['apply_status']);
            $one['file_url'] = $changInfo['file_url'];
            if (isset(SchoolDao::$applyStatus[$one['apply_status']])) {
                $one['status'] = SchoolDao::$applyStatus[$one['apply_status']];
            }else
                $one['status'] = '';
        }
        return $list;
    }

    public function addProfession($schoolId, $class, $name, $link, $endTime, $endTimeLink, $practice, $honors, $remark) {
        $professionDao = new ProfessionDao();
        $ret = $professionDao->addProfession($schoolId, $class, $name, $link, $endTime, $endTimeLink, $practice, $honors, $remark);
        return $ret;
    }
}
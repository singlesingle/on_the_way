<?php

namespace app\tasks;

use app\models\BasicInfoDao;
use app\models\CustomerDao;
use app\models\MaterialDao;
use app\models\SchoolDao;
use yii\console\Controller;

class StatusController extends Controller{

    public function actionChange()
    {
        $customerDao = new CustomerDao();
        $basicInfoDao = new BasicInfoDao();
        $materialDao = new MaterialDao();
        $schoolDao = new SchoolDao();
        $customerList = $customerDao->queryAllList();
        foreach ($customerList as $customer) {
            //申请状态，判断是否需要从“未开始”变为“申请中”
            //客户申请材料已收齐（客户基础信息、教育背景、留学材料），状态变为申请中
            if ($customer['apply_status'] == CustomerDao::$applyStatusDict['未开始']) {
                $basicInfo = $basicInfoDao->queryByCustomerId($customer['id']);
                if ($basicInfo['id_number'] && $basicInfo['email'] && $basicInfo['mail_address']
                    && $basicInfo['birthday'] && $basicInfo['gender'] && $basicInfo['passport']){
                    $materialList = $materialDao->queryByCustomerId($customer['id']);
                    if (count($materialList) > 0) {
                        $customerDao->updateApplyStatus($customer['id'], CustomerDao::$applyStatusDict['申请中']);
                    }
                }
            }
            //申请状态，判断是否需要从“申请中”变为“已完成”
            //所有申请学校，全部有个结果，状态变为已完成
            elseif ($customer['apply_status'] == CustomerDao::$applyStatusDict['申请中']) {
                $over = true;
                $schoolList = $schoolDao->queryById($customer['id']);
                foreach ($schoolList as $school) {
                    if ($school['apply_status'] == SchoolDao::$applyStatusName['录取'] || $school['apply_status'] == SchoolDao::$applyStatusName['未录取']
                    || $school['apply_status'] == SchoolDao::$applyStatusName['确认入读']) {
                        continue;
                    }else {
                        $over = false;
                        break;
                    }
                }
                if ($over) {
                    $customerDao->updateApplyStatus($customer['id'], CustomerDao::$applyStatusDict['已完成']);
                }
            }

            //结案状态，判断是否需要从“未结案”变为“已结案”
            //学生签证有结果，申请学校全部有结果状态变为已结案
            if ($customer['visa_status'] == CustomerDao::$visaStatusDict['获签']
                || $customer['visa_status'] == CustomerDao::$visaStatusDict['拒签']) {
                $over = true;
                $schoolList = $schoolDao->queryById($customer['id']);
                foreach ($schoolList as $school) {
                    if ($school['apply_status'] == SchoolDao::$applyStatusName['录取'] || $school['apply_status'] == SchoolDao::$applyStatusName['未录取']
                        || $school['apply_status'] == SchoolDao::$applyStatusName['确认入读']) {
                        continue;
                    }else {
                        $over = false;
                        break;
                    }
                }
                if ($over) {
                    $customerDao->updateCloseCaseStatus($customer['id'], CustomerDao::$closeCaseStatusDict['已结案']);
                }
            }
        }
    }
}


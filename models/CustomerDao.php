<?php

namespace app\models;

use app\classes\Log;
use Yii;
use yii\db\ActiveRecord;

class CustomerDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "customer";
    }

//    //废弃
//    public static $progress = [
//        1 => '已签约',
//    ];
//
//    public static $progressDict = [
//        '已签约' => 1,
//    ];
//
//    //废弃
//    public static $bindWechat = [
//        0 => '未绑定',
//        1 => '已绑定',
//    ];
//
//    public static $bindWechatDict = [
//        '未绑定' => 0,
//        '已绑定' => 1,
//    ];

//    //废弃
//    public static $selectCheck = [
//        1 => '已提交',
//        2 => '已通过',
//        3 => '已确认',
//    ];
//
//    public static $selectCheckDict = [
//        '已提交' => 1,
//        '已通过' => 2,
//        '已确认' => 3,
//    ];
//
//    //废弃
//    public static $applyStage = [
//        0 => "待投递",
//        1 => "申请材料递出",
//        2 => "投递跟进",
//        3 => "基础材料齐全",
//        4 => "录取结果跟进",
//        5 => "已拒录",
//        6 => "已录取",
//        7 => "已放弃",
//        8 => "确认入读",
//    ];
//
//    public static $applyStageDict = [
//        "待投递" => 0,
//        "申请材料递出" => 1,
//        "投递跟进" => 2,
//        "基础材料齐全" => 3,
//        "录取结果跟进" => 4,
//        "已拒录" => 5,
//        "已录取" => 6,
//        "已放弃" => 7,
//        "确认入读" => 8,
//    ];

    public static $status = [
        "正常" => 0,
        "删除" => 1,
    ];

    public static $serviceType = [
        1 => '单文书',
        2 => '全程服务',
        3 => '单申请',
        4 => '签证',
    ];

    public static $serviceTypeDict = [
        '单文书'   => 1,
        '全程服务' => 2,
        '单申请'   => 3,
        '签证'     => 4,
    ];

    public static $applyStatus = [
        0 => "未开始",
        1 => "申请中",
        2 => "已完成",
    ];

    public static $applyStatusDict = [
        "未开始" => 0,
        "申请中" => 1,
        "已完成" => 2,
    ];

    public static $visaStatus = [
        0 => "待申请",
        1 => "签证递交",
        2 => "获签",
        3 => "拒签",
    ];

    public static $visaStatusDict = [
        "待申请" => 0,
        "签证递交" => 1,
        "获签" => 2,
        "拒签" => 3,
    ];

    public static $closeCaseStatus = [
        1 => "未结案",
        2 => "已结案",
    ];

    public static $closeCaseStatusDict = [
        "未结案" => 1,
        "已结案" => 2,
    ];

    public static $collectStatus = [
        0 => "未收集完成",
        1 => "收集完成",
    ];

    public static $collectStatusDict = [
        "未收集完成" => 0,
        "收集完成" => 1,
    ];

    public static $applyProject = [
        1 => '初中',
        2 => '高中',
        3 => '本科',
        4 => '硕士',
    ];

    public static $applyProjectDict = [
        '初中' => 1,
        '高中' => 2,
        '本科' => 3,
        '硕士' => 4,
    ];

    public static $applyCountry = [
        1 => '英国',
        2 => '加拿大',
        3 => '澳大利亚',
        4 => '欧洲',
        5 => '新西兰',
        6 => '爱尔兰',
        7 => '香港',
    ];

    public static $applyCountryDict = [
        '英国'     => 1,
        '加拿大'   => 2,
        '澳大利亚' => 3,
        '欧洲'     => 4,
        '新西兰'   => 5,
        '爱尔兰'   => 6,
        '香港'     => 7,
    ];

    //新增客户
    public function addCustomer($userId, $name, $contractId, $phone, $wechat, $applyCountry, $applyProject, $serviceType,
                                $goAbroadYear, $consultant, $applyStatus, $visaStatus, $closeCaseStatus) {
        $curTime = date("Y-m-d H:i:s");
        $sql = sprintf('INSERT INTO %s (user_id, name, contract_id, phone, wechat, apply_country, apply_project, service_type,
              go_abroad_year, consultant, apply_status, visa_status, close_case_status, update_time, create_time)
              values (%d, :name, :contract_id, :phone, :wechat, :apply_country, :apply_project, %d, 
              :go_abroad_year, :consultant, %d, %d, %d, :update_time, :create_time)',
            self::tableName(), $userId, $serviceType,
            $applyStatus, $visaStatus, $closeCaseStatus);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':contract_id', $contractId, \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':wechat', $wechat, \PDO::PARAM_STR);
        $stmt->bindParam(':apply_country', $applyCountry, \PDO::PARAM_INT);
        $stmt->bindParam(':apply_project', $applyProject, \PDO::PARAM_INT);
        $stmt->bindParam(':go_abroad_year', $goAbroadYear, \PDO::PARAM_STR);
        $stmt->bindParam(':consultant', $consultant, \PDO::PARAM_STR);
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $stmt->execute();
        $id = self::getDb()->getLastInsertID();
        return $id;
    }

    //查询客户
    public function queryListByUser($userIds) {
        $userIdStr = implode(',', $userIds);
        $sql=sprintf('SELECT * FROM %s WHERE user_id in (:user_ids)', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':user_ids', $userIdStr, \PDO::PARAM_STR);
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //查询用户负责的客户列表
    public function queryAllList() {
        $sql=sprintf('SELECT * FROM %s WHERE status = :status', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':status', self::$status['正常'], \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //查询用户信息
    public function queryById($id) {
        $sql=sprintf('SELECT * FROM %s WHERE id = :id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //更新客户
    public function updateCustomer($id, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear,
                                   $lineBusiness, $wechat, $communication) {
        $curTime = date("Y-m-d H:i:s");
        $sql = sprintf('UPDATE %s SET name = :name, contract_id = :contract_id, phone = :phone, wechat = :wechat,
            apply_country = :apply_country, apply_project = :apply_project, service_type = :service_type, go_abroad_year = :go_abroad_year,
            line_business = :line_business, communication = :communication, update_time = :update_time WHERE id = %d',
            self::tableName(), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':contract_id', $contractId, \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':wechat', $wechat, \PDO::PARAM_STR);
        $stmt->bindParam(':apply_country', $applyCountry, \PDO::PARAM_STR);
        $stmt->bindParam(':apply_project', $applyProject, \PDO::PARAM_STR);
        $stmt->bindParam(':service_type', $serviceType, \PDO::PARAM_INT);
        $stmt->bindParam(':go_abroad_year', $goAbroadYear, \PDO::PARAM_STR);
        $stmt->bindParam(':line_business', $lineBusiness, \PDO::PARAM_STR);
        $stmt->bindParam(':communication', $communication, \PDO::PARAM_STR);
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }


    //根据条件查询客户列表
    public function listByCondition($applyCountry, $applyProject, $serviceType, $goAbroadYear, $applyStatus, $visaStatus,
                                    $closeCaseStatus, $iDisplayStart, $iDisplayLength, $userId) {
        $search_filed = [];
        if ($applyCountry !== '') {
            $search_filed[] = 'apply_country = ' . $applyCountry;
        }
        if ($applyProject !== '') {
            $search_filed[] = 'apply_project = ' . $applyProject;
        }
        if ($serviceType !== '') {
            $search_filed[] = 'service_type = ' . $serviceType;
        }
        if ($goAbroadYear !== '') {
            $search_filed[] = 'go_abroad_year = ' . $goAbroadYear;
        }
        if ($applyStatus !== '') {
            $search_filed[] = 'apply_status = ' . $applyStatus;
        }
        if ($visaStatus !== '') {
            $search_filed[] = 'visa_status = ' . $visaStatus;
        }
        if ($closeCaseStatus !== '') {
            $search_filed[] = 'close_case_status = ' . $closeCaseStatus;
        }
        if (count($userId) > 0) {
            $search_filed[] = 'user_id in (' . implode(',', $userId) . ')';
        }
        $search_filed[] = 'status = ' . self::$status['正常'];
        $sql = sprintf('SELECT * FROM %s WHERE %s LIMIT %d,%d',
            self::tableName(), implode(' AND ', $search_filed), $iDisplayStart, $iDisplayLength);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //根据条件查询客户数量
    public function countByCondition($applyCountry, $applyProject, $serviceType, $goAbroadYear, $applyStatus, $visaStatus,
                                    $closeCaseStatus, $userId) {
        $search_filed = [];
        if ($applyCountry !== '') {
            $search_filed[] = 'apply_country = ' . $applyCountry;
        }
        if ($applyProject !== '') {
            $search_filed[] = 'apply_project = ' . $applyProject;
        }
        if ($serviceType !== '') {
            $search_filed[] = 'service_type = ' . $serviceType;
        }
        if ($goAbroadYear !== '') {
            $search_filed[] = 'go_abroad_year = ' . $goAbroadYear;
        }
        if ($applyStatus !== '') {
            $search_filed[] = 'apply_status = ' . $applyStatus;
        }
        if ($visaStatus !== '') {
            $search_filed[] = 'visa_status = ' . $visaStatus;
        }
        if ($closeCaseStatus !== '') {
            $search_filed[] = 'close_case_status = ' . $closeCaseStatus;
        }
        if (count($userId) > 0) {
            $search_filed[] = 'user_id in (' . implode(',', $userId) . ')';
        }
        $search_filed[] = 'status = ' . self::$status['正常'];
        $sql = sprintf('SELECT count(1) as c FROM %s WHERE %s',
            self::tableName(), implode(' AND ', $search_filed));
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //更新客户签证状态
    public function updateVisaStatus($id, $visaStatus) {
        $sql = sprintf('UPDATE %s SET visa_status = %d WHERE id = %d',
            self::tableName(), $visaStatus, $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //更新客户申请状态
    public function updateApplyStatus($id, $applyStatus) {
        $sql = sprintf('UPDATE %s SET apply_status = %d WHERE id = %d',
            self::tableName(), $applyStatus, $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //更新客户结案状态
    public function updateCloseCaseStatus($id, $closeCaseStatus) {
        $sql = sprintf('UPDATE %s SET close_case_status = %d WHERE id = %d',
            self::tableName(), $closeCaseStatus, $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //根据微信昵称查询用户信息
    public function queryByWechat($nickName) {
        $sql=sprintf('SELECT * FROM %s WHERE wechat = :wechat', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':wechat', $nickName, \PDO::PARAM_STR);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //根据客户名字查询客户信息
    public function queryByName($name) {
        $sql=sprintf('SELECT * FROM %s WHERE name = :name AND status = %d', self::tableName(), self::$status['正常']);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //更新客户备注信息
    public function updateRemark($id, $communication) {
        $sql = sprintf('UPDATE %s SET communication = :communication WHERE id = %d',
            self::tableName(), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':communication', $communication, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    public function deleteCustomer($id) {
        $sql = sprintf('UPDATE %s SET status = %d WHERE id = %d',
            self::tableName(), self::$status['删除'], $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }
}
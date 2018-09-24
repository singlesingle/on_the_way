<?php

namespace app\models;

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

    public static $status = [
        "正常" => 0,
        "删除" => 1,
    ];

    public static $progress = [
        1 => '已签约',
    ];

    public static $progressDict = [
        '已签约' => 1,
    ];

    public static $bindWechat = [
        0 => '未绑定',
        1 => '已绑定',
    ];

    public static $bindWechatDict = [
        '未绑定' => 0,
        '已绑定' => 1,
    ];

    public static $serviceType = [
        1 => '全程服务',
        2 => '签证',
    ];

    public static $serviceTypeDict = [
        '全程服务' => 1,
        '签证' => 2,
    ];

    public static $selectCheck = [
        1 => '已确认',
    ];

    public static $selectCheckDict = [
        '已确认' => 1,
    ];

    public static $applyStatus = [
        0 => "申请中",
    ];

    public static $applyStatusDict = [
        "申请中" => 0,
    ];

    public static $visaStatus = [
        0 => "待申请",
    ];

    public static $visaStatusDict = [
        "待申请" => 0,
    ];

    public static $closeCaseStatus = [
        1 => "未提交"
    ];

    public static $closeCaseStatusDict = [
        "未提交" => 1
    ];

    public static $closeCaseType = [

    ];

    public static $closeCaseTypeDict = [

    ];

    public static $applyProject = [
        1 => '硕士',
        2 => '硕士预科',
        3 => '单签证'
    ];

    public static $applyProjectDict = [
        '硕士' => 1,
        '硕士预科' => 2,
        '单签证' => 3
    ];

    //新增客户
    public function addCustomer($userId, $name, $contractId, $phone, $progress, $wechat, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness,
                                $selectCheck, $applyStatus, $visaStatus, $closeCaseStatus, $closeCaseType) {
        $curTime = date("Y-m-d H:i:s");
        $sql = sprintf('INSERT INTO %s (user_id, name, contract_id, phone, progress, wechat, apply_country, apply_project, service_type, go_abroad_year,
            line_business, select_check, apply_status, visa_status, close_case_status, close_case_type, update_time, create_time)
            values (%d, :name, :contract_id, :phone, :progress, :wechat, :apply_country, :apply_project, %d, :go_abroad_year,
            :line_business, :select_check, %d, %d, %d, %d, :update_time, :create_time)',
            self::tableName(), $userId, $serviceType, $goAbroadYear, $lineBusiness,
            $selectCheck, $applyStatus, $visaStatus, $closeCaseStatus, $closeCaseType);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':contract_id', $contractId, \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':progress', $progress, \PDO::PARAM_STR);
        $stmt->bindParam(':wechat', $wechat, \PDO::PARAM_STR);
        $stmt->bindParam(':apply_country', $applyCountry, \PDO::PARAM_STR);
        $stmt->bindParam(':apply_project', $applyProject, \PDO::PARAM_STR);
        $stmt->bindParam(':go_abroad_year', $goAbroadYear, \PDO::PARAM_STR);
        $stmt->bindParam(':line_business', $lineBusiness, \PDO::PARAM_STR);
        $stmt->bindParam(':select_check', $selectCheck, \PDO::PARAM_STR);
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
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

    //新增客户
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
}
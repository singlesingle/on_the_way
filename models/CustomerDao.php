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

    //新增客户
    public function addCustomer($userId, $name, $phone, $progress, $wechat, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness,
                                $selectCheck, $applyStatus, $visaStatus, $closeCaseStatus, $closeCaseType) {
        $sql = sprintf('INSERT INTO %s (user_id, name, phone, progress, wechat, apply_country, apply_project, service_type, go_abroad_year,
            line_business, select_check, apply_status, visa_status, close_case_status, close_case_type, update_time, create_time)
            values (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)',
            self::tableName(), $userId, $name, $phone, $progress, $wechat, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness,
            $selectCheck, $applyStatus, $visaStatus, $closeCaseStatus, $closeCaseType);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //查询客户
    public function queryById($id) {
        $sql=sprintf('SELECT * FROM %s WHERE id = :id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //查询用户负责的客户列表
    public function queryByUserId($userId) {
        $sql=sprintf('SELECT * FROM %s WHERE user_id = :user_id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }
}
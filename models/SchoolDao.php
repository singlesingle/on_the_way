<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class SchoolDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "school";
    }

    public static $applyStatus = [
        1 => '待申请',
        2 => '文书已完成',
        3 => '已申请',
        4 => '录取',
        5 => '未录取',
        6 => '确认入读',
    ];

    public static $applyStatusName = [
        '待申请' => 1,
        '文书已完成' => 2,
        '已申请' => 3,
        '录取' => 4,
        '未录取' => 5,
        '确认入读' => 6,
    ];

    //新增学校
    public function addSchool($customerId, $name, $schoolArea, $degree, $admissionTime) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (customer_id, name, school_area, degree, admission_time, apply_status, create_time)
            values (%d, :name, :school_area, :degree, :admission_time, %d, :create_time)",
            self::tableName(), $customerId, self::$applyStatusName['待申请']);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':school_area', $schoolArea, \PDO::PARAM_STR);
        $stmt->bindParam(':degree', $degree, \PDO::PARAM_STR);
        $stmt->bindParam(':admission_time', $admissionTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $stmt->execute();
        $id = self::getDb()->getLastInsertID();
        return $id;
    }

    //查询客户的学校列表
    public function queryById($customerId) {
        $sql=sprintf('SELECT a.id, a.apply_status, a.name as school_name, b.name as profession_name,
              school_area, end_time, admission_time, degree, honors, practice, b.create_time
              FROM %s as a INNER JOIN profession as b 
              ON a.id = b.school_id WHERE customer_id = %d', self::tableName(), $customerId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //更新学校申请状态
    public function updateApplyStatus($id, $applyStatus) {
        $sql = sprintf('UPDATE %s SET apply_status = %d WHERE id = %d',
            self::tableName(), $applyStatus, $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //查询学校列表
    public function schoolList() {
        $sql=sprintf('SELECT * FROM %s', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }
}
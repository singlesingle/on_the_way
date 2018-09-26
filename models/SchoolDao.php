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

    //新增学校
    public function addSchool($customerId, $name, $schoolArea, $degree, $admissionTime) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (customer_id, name, school_area, degree, admission_time, create_time)
            values (%d, :name, :school_area, :degree, :admission_time, :create_time)",
            self::tableName(), $customerId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':school_area', $schoolArea, \PDO::PARAM_STR);
        $stmt->bindParam(':degree', $degree, \PDO::PARAM_STR);
        $stmt->bindParam(':admission_time', $admissionTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //查询客户的学校列表
    public function queryById($customerId) {
        $sql=sprintf('SELECT * FROM %s WHERE customer_id = %d', self::tableName(), $customerId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }
}
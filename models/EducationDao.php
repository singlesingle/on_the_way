<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class EducationDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "education";
    }

    public function addEducationInfo($customerId) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (customer_id, create_time) values (%d, :create_time)",
            self::tableName(), $customerId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //更新教育信息
    public function updateEducationInfo($id, $startTime, $endTime, $major, $level, $address, $schoolName,
                                        $rank, $type, $schoolWeb, $phone) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("UPDATE %s SET start_time = :start_time, end_time = :end_time, major = :major,
              `level` = :level, address = :address, school_name = :school_name, rank = :rank, `type` = :type,
              school_web = :school_web, phone = :phone, create_time = :create_time WHERE id = %d",
            self::tableName(), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':start_time', $startTime, \PDO::PARAM_STR);
        $stmt->bindParam(':end_time', $endTime, \PDO::PARAM_STR);
        $stmt->bindParam(':major', $major, \PDO::PARAM_STR);
        $stmt->bindParam(':level', $level, \PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, \PDO::PARAM_STR);
        $stmt->bindParam(':school_name', $schoolName, \PDO::PARAM_STR);
        $stmt->bindParam(':rank', $rank, \PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':school_web', $schoolWeb, \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    public function queryByCustomerId($customerId) {
        $sql=sprintf('SELECT * FROM %s WHERE customer_id = :customer_id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':customer_id', $customerId, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }
}
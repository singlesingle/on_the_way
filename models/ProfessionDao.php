<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ProfessionDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "profession";
    }

    public static $practice = [
        1 => '是',
        2 => '否',
    ];

    public static $honors = [
        1 => '是',
        2 => '否',
    ];

    //新增专业
    public function addProfession($schoolId, $class, $name, $link, $endTime, $endTimeLink, $practice, $honors, $remark) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (school_id, class, name, link, end_time, end_time_link, practice, honors, remark, create_time)
            values (%d, :class, :name, :link, :end_time, :end_time_link, %d, %d, :remark, :create_time)",
            self::tableName(), $schoolId, $practice, $honors);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':class', $class, \PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':link', $link, \PDO::PARAM_STR);
        $stmt->bindParam(':end_time', $endTime, \PDO::PARAM_STR);
        $stmt->bindParam(':end_time_link', $endTimeLink, \PDO::PARAM_STR);
        $stmt->bindParam(':remark', $remark, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //查询某个学校的专业列表
    public function queryBySchool($schoolId) {
        $sql = sprintf("SELECT * FROM %s WHERE school_id = %d",
            self::tableName(), $schoolId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }
}
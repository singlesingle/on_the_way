<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class StatusChangeDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "status_change";
    }

    public static $type = [
        1 => '申请状态',
        2 => '签证状态',
    ];

    //新增案例
    public function addStatusChange($customerId, $userId, $type, $status, $fileUrl) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (customer_id, user_id, type, status, file_url, create_time)
            values (%d, %d, %d, %d, :file_url, :create_time)",
            self::tableName(), $customerId, $userId, $type, $status
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':file_url', $fileUrl, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //查询用户添加的客户案例
    public function queryChangeInfo($customerId, $type, $status) {
        $sql=sprintf('SELECT * FROM %s WHERE customer_id = %d AND type = %d AND status = %d',
            self::tableName(), $customerId, $type, $status);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }
}
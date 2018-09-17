<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class MessageDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "message";
    }

    public static $status = [
        "正常" => 0,
        "删除" => 1
    ];

    public static $type = [
        "系统消息" => 1,
        "进度消息" => 2
    ];

    //添加消息
    public function addMessage($type, $title, $content, $userId) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf('INSERT INTO %s (type, title, content, user_id, status, update_time, create_time)
            values (%d, %s, %s, %s, %d, %s, %s)',
            self::tableName(), $type, $title, $content, $userId, self::$status['正常'], $curTime, $curTime
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $id = $stmt->lastInsertId;
        return $id;
    }

    //系统消息列表
    public function systemMessageList() {
        $sql=sprintf('SELECT * FROM %s WHERE status = :status', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':status', self::$status['正常'], \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }
}
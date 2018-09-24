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
        "未发布" => 0,
        "删除" => 1,
        "发布" => 2
    ];

    public static $type = [
        "系统消息" => 1,
        "进度消息" => 2
    ];

    //添加消息
    public function addMessage($type, $title, $content, $userId) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf('INSERT INTO %s (type, title, content, user_id, status, update_time, create_time)
            values (%d, :title, :content, %d, %d, :update_time, :create_time)',
            self::tableName(), $type, $userId, self::$status['正常']
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //系统消息列表
    public function systemMessageList() {
        $sql=sprintf('SELECT * FROM %s WHERE status != :status AND type = %d', self::tableName(), self::$type['系统消息']);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':status', self::$status['删除'], \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //系统消息列表
    public function queryById($id) {
        $sql=sprintf('SELECT * FROM %s WHERE status != :status AND id = %d', self::tableName(), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':status', self::$status['删除'], \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //删除消息
    public function deleteById($id) {
        $sql=sprintf('UPDATE %s SET status = :status WHERE id = %d', self::tableName(), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':status', self::$status['删除'], \PDO::PARAM_INT);
        $ret = $stmt->execute();
        return $ret;
    }

    //更新消息状态
    public function updateStatusById($id, $status) {
        $sql=sprintf('UPDATE %s SET status = %d WHERE id = %d', self::tableName(), $status, $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }
}
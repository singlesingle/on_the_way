<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class MessageSenderDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "message_sender";
    }

    public static $isRead = [
        "未读" => 0,
        "已读" => 1
    ];

    //新增待查看消息
    public function addMessageSender($messageId, $acceptUserId) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf('INSERT INTO %s (message_id, accept_user_id, is_read, update_time, create_time) values (%d, %d, %d, :update_time, :create_time)',
            self::tableName(), $messageId, $acceptUserId, self::$isRead['未读']);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //查询某个用户的消息列表
    public function queryUserMessageList($userId, $iDisplayStart, $iDisplayLength) {
        $sql = sprintf('SELECT b.id, b.title, a.create_time, a.is_read FROM %s as a INNER JOIN message as b ON a.message_id = b.id WHERE accept_user_id = %d LIMIT %d,%d',
            self::tableName(), $userId, $iDisplayStart, $iDisplayLength);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //更新消息状态为已读
    public function updateRead($messageId, $acceptUserId) {
        $sql = sprintf('UPDATE %s SET is_read = %d WHERE message_id = %d AND accept_user_id = %d',
            self::tableName(), self::$isRead['已读'], $messageId, $acceptUserId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //查询用户未读消息
    public function queryUnreadMessage($userId) {
        $sql = sprintf('SELECT b.title, a.create_time, b.id FROM %s as a INNER JOIN message as b ON a.message_id = b.id
            WHERE accept_user_id = %d AND a.is_read = %d ORDER BY a.create_time DESC', self::tableName(), $userId, self::$isRead['未读']);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

}
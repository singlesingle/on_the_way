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

    /**
     * 新增待查看消息
     * @param $messageId
     * @param $acceptUserId
     * @return int
     * @throws \yii\db\Exception
     */
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

    //更新消息状态为已读
    public function updateRead($messageId, $acceptUserId) {
        $sql = sprintf('UPDATE %s SET is_read = %d WHERE message_id = %d, accept_user_id = %d',
            self::tableName(), self::$isRead['已读'], $messageId, $acceptUserId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }
}
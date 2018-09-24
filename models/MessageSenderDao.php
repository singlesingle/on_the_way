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

    /**
     * 更新用户信息
     * @param $id
     * @param $name
     * @param $pwd
     * @param $phone
     * @param $introduce
     * @return bool|int
     * @throws \yii\db\Exception
     */
    public function updateUserInfo($id, $name, $pwd, $phone, $introduce) {
        $update_filed = [];
        if ($name != '') {
            $update_filed[] = 'name = ' . $name;
        }
        if ($pwd != '') {
            $update_filed[] = 'pwd = ' . $pwd;
        }
        if ($phone != '') {
            $update_filed[] = 'phone = ' . $phone;
        }
        if ($introduce != '') {
            $update_filed[] = 'introduce = ' . $introduce;
        }
        if (count($update_filed) == 0) {
            return false;
        }
        $sql = sprintf('UPDATE %s SET %s WHERE id = %d',
            self::tableName(), implode(',', $update_filed), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    /**
     * 查询用户
     * @param $id
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function queryById($id) {
        $sql=sprintf('SELECT * FROM %s WHERE id = :id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //查询用户消息列表
    public function queryUserMessageList($userId, $iDisplayStart, $iDisplayLength) {
        $sql=sprintf('SELECT * FROM %s as a INNER JOIN %s as b ON a.message_id = b.id WHERE accept_user_id = %d and status != %d limit %d,%d',
            self::tableName(), 'message', $userId, MessageDao::$status['删除'], $iDisplayStart, $iDisplayLength);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }
}
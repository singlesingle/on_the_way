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

    /**
     * 添加消息
     * @param $type
     * @param $title
     * @param $content
     * @param $announcer
     * @return int
     * @throws \yii\db\Exception
     */
    public function addMessage($type, $title, $content, $announcer) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf('INSERT INTO %s (type, title, content, announcer, status, update_time, create_time)
            values (%d, %s, %s, %s, %d, %s, %s)',
            self::tableName(), $type, $title, $content, $announcer, self::$status['正常'], $curTime, $curTime
        );
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
}
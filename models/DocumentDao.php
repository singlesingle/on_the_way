<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class DocumentDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "document";
    }

    public static $status = [
        "正常" => 0,
        "删除" => 1
    ];

    /**
     * 添加文书
     * @param $customerId
     * @param $name
     * @param $rank
     * @param $profession
     * @param $type
     * @param $annex
     * @return int
     * @throws \yii\db\Exception
     */
    public function addDocument($customerId, $name, $rank, $profession, $type, $annex) {
        $curTime = date("Y-m-d H:i:s");
        $sql = sprintf('INSERT INTO %s (customer_id, name, rank, profession, type, annex, status, update_time, create_time)
            values (%d, %s, %s, %s, %d, %s, %d, %s, %s)',
            self::tableName(), $customerId, $name, $rank, $profession, $type, $annex, self::$status['正常'], $curTime, $curTime
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    /**
     * 查询文书
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
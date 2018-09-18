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
            values (%d, :name, :rank, :profession, %d, :annex, %d, :update_time, :create_time)',
            self::tableName(), $customerId, $type, self::$status['正常']
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':rank', $rank, \PDO::PARAM_STR);
        $stmt->bindParam(':profession', $profession, \PDO::PARAM_STR);
        $stmt->bindParam(':annex', $annex, \PDO::PARAM_STR);
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
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
<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CaseDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "case";
    }

    /**
     * 新增案例
     * @param $customerId
     * @param $admissionSchool
     * @param $rank
     * @param $profession
     * @param $result
     * @param $entryTime
     * @param $graduatedSchool
     * @param $summary
     * @return int
     * @throws \yii\db\Exception
     */
    public function addCase($customerId, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf('INSERT INTO %s (customer_id, admission_school, rank, profession, result, entry_time,
              graduated_school, summary, check_pass_time, update_time, create_time)
            values (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)',
            self::tableName(), $customerId, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool,
            $summary, '0000-00-00 00:00:00', $curTime, $curTime
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
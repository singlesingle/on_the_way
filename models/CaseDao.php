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

    //新增案例
    public function addCase($customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf('INSERT INTO %s (customer_id, title, admission_school, rank, profession, result, entry_time,
              graduated_school, summary, check_pass_time, update_time, create_time)
            values (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)',
            self::tableName(), $customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool,
            $summary, '0000-00-00 00:00:00', $curTime, $curTime
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //修改案例
    public function updateCase($customerId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf('UPDATE %s SET title = %s, admission_school = %s, rank = %s, profession = %s, result = %d, entry_time = %s,
              graduated_school = %s, summary = %s, check_pass_time = %s, update_time = %s, create_time = %s WHERE customer_id = %d',
            self::tableName(), $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool,
            $summary, '0000-00-00 00:00:00', $curTime, $curTime, $customerId
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //查询案例信息
    public function queryById($id) {
        $sql=sprintf('SELECT * FROM %s WHERE id = :id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //查询用户添加的客户案例
    public function queryMyCase($userId) {
        $sql=sprintf('SELECT * FROM %s as a INNER JOIN %s as b ON a.customer_id = b.id WHERE b.user_id = %d',
            self::tableName(), 'customer', $userId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //查询内部客户案例
    public function queryAllCase() {
        $sql=sprintf('SELECT * FROM %s as a INNER JOIN %s as b ON a.customer_id = b.id',
            self::tableName(), 'customer');
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //删除案例
    public function deleteCase($id) {
        $sql=sprintf('DELETE FROM %s WHERE id = :id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $ret = $stmt->execute();
        return $ret;
    }
}
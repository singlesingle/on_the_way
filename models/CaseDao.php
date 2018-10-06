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
        return "`case`";
    }

    public static $result = [
        1 => '录取',
        2 => '未录取',
    ];

    //新增案例
    public function addCase($customerId, $createUserId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (customer_id, create_user_id, title, admission_school, rank, profession, result, entry_time,
              graduated_school, summary, update_time, create_time)
            values (%d, %d, :title, :admission_school, :rank, :profession, %d, :entry_time, :graduated_school,
            :summary, :update_time, :create_time)",
            self::tableName(), $customerId, $createUserId, $result
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':admission_school', $admissionSchool, \PDO::PARAM_STR);
        $stmt->bindParam(':rank', $rank, \PDO::PARAM_STR);
        $stmt->bindParam(':profession', $profession, \PDO::PARAM_STR);
        $stmt->bindParam(':entry_time', $entryTime, \PDO::PARAM_STR);
        $stmt->bindParam(':graduated_school', $graduatedSchool, \PDO::PARAM_STR);
        $stmt->bindParam(':summary', $summary, \PDO::PARAM_STR);
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //修改案例
    public function updateCase($caseId, $title, $admissionSchool, $rank, $profession, $result, $entryTime, $graduatedSchool, $summary) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("UPDATE %s SET title = :title, admission_school = :admission_school, rank = :rank, profession = :profession,
              result = %d, entry_time = :entry_time, graduated_school = :graduated_school, summary = :summary, check_pass_time = '0000-00-00 00:00:00',
              update_time = :update_time, create_time = :create_time WHERE id = %d",
            self::tableName(), $result, $caseId
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':admission_school', $admissionSchool, \PDO::PARAM_STR);
        $stmt->bindParam(':rank', $rank, \PDO::PARAM_STR);
        $stmt->bindParam(':profession', $profession, \PDO::PARAM_STR);
        $stmt->bindParam(':entry_time', $entryTime, \PDO::PARAM_STR);
        $stmt->bindParam(':graduated_school', $graduatedSchool, \PDO::PARAM_STR);
        $stmt->bindParam(':summary', $summary, \PDO::PARAM_STR);
        $stmt->bindParam(':update_time', $curTime, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
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
        $sql=sprintf('SELECT *, a.id as case_id FROM %s as a INNER JOIN %s as b ON a.customer_id = b.id WHERE create_user_id = %d',
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
<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class UserDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "user";
    }

    public static $status = [
        "正常" => 0,
        "删除" => 1,
        "禁用" => 2,
    ];

    public static $role = [
        "管理员" => 1,
        "总监" => 2,
        "文案人员" => 3,
    ];
  
    public static $role_name = [
        1 => "管理员",
        2 => "总监",
        3 => "文案人员",
    ];

    /**
     * 新增用户
     * @param $fid
     * @param $name
     * @param $role
     * @param $pwd
     * @param $phone
     * @param $introduce
     * @return int
     * @throws \yii\db\Exception
     */
    public function addUser($fid, $name, $role, $pwd, $phone, $introduce) {
        $sql = sprintf('INSERT INTO %s (fid, name, role, pwd, phone, introduce) values (:fid, :name, :role, :pwd, :phone, :introduce)',
            self::tableName()
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':fid', $fid, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, \PDO::PARAM_INT);
        $stmt->bindParam(':pwd', $pwd, \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':introduce', $introduce, \PDO::PARAM_STR);
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

    //查询用户
    public function queryById($id) {
        $sql=sprintf('SELECT * FROM %s WHERE id = :id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //根据手机号查询用户信息
    public function queryByPhone($phone) {
        $sql=sprintf('SELECT * FROM %s WHERE phone = :phone and status != :status', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':status', self::$status['删除'], \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }

    //查询用户列表
    public function userList() {
        $sql=sprintf('SELECT * FROM %s WHERE status != %d', self::tableName(), self::$status['删除']);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }

    //删除用户
    public function deleteUser($id) {
        $sql = sprintf('UPDATE %s SET status = %d WHERE id = %d',
            self::tableName(), self::$status['删除'], $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //禁用用户
    public function disableUser($id) {
        $sql = sprintf('UPDATE %s SET status = %d, lock_total = 0 WHERE id = %d',
            self::tableName(), self::$status['禁用'], $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //启用用户
    public function enableUser($id) {
        $sql = sprintf('UPDATE %s SET status = %d WHERE id = %d',
            self::tableName(), self::$status['正常'], $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //用户转岗
    public function transferUser($userId, $leaderUserId) {
        $sql = sprintf('UPDATE %s SET fid = %d WHERE id = %d',
            self::tableName(), $leaderUserId, $userId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    //用户密码错误数累计
    public function countError($id) {
        $sql = sprintf('UPDATE %s SET lock_total = lock_total + 1 WHERE id = %d',
            self::tableName(), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }
}

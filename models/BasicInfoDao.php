<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class BasicInfoDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "basic_info";
    }

    public static $gender = [
        1 => '男',
        2 => '女',
    ];

    public static $maritalStatus = [
        1 => '已婚',
        2 => '未婚',
        3 => '离异',
    ];

    //新增基础信息
    public function addBasicInfo($customerId) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (customer_id, create_time) values (%d, :create_time)",
            self::tableName(), $customerId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //更新基础信息
    public function updateBasicInfo($id, $namePinyin, $englishName, $usedName, $idNumber, $email, $landlineNumber, $address,
                                 $zipCode, $mailAddress, $mailZipCode, $placeBirth, $birthday, $gender, $nativeLanguage, $secondLanguage,
                                 $country, $maritalStatus, $passport, $passportPlace, $passportDate) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("UPDATE %s SET name_pinyin = :name_pinyin, english_name = :english_name, used_name = :used_name,
              id_number = :id_number, email = :email, landline_number = :landline_number, address = :address, zip_code = :zip_code,
              mail_address = :mail_address, mail_zip_code = :mail_zip_code, place_birth = :place_birth, birthday = :birthday, 
              gender = :gender, native_language = :native_language, second_language = :second_language, country = :country,
              marital_status = :marital_status, passport = :passport, passport_place = :passport_place, passport_date = :passport_date, 
              create_time = :create_time WHERE id = %d",
            self::tableName(), $id);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name_pinyin', $namePinyin, \PDO::PARAM_STR);
        $stmt->bindParam(':english_name', $englishName, \PDO::PARAM_STR);
        $stmt->bindParam(':used_name', $usedName, \PDO::PARAM_STR);
        $stmt->bindParam(':id_number', $idNumber, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':landline_number', $landlineNumber, \PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, \PDO::PARAM_STR);
        $stmt->bindParam(':zip_code', $zipCode, \PDO::PARAM_STR);
        $stmt->bindParam(':mail_address', $mailAddress, \PDO::PARAM_STR);
        $stmt->bindParam(':mail_zip_code', $mailZipCode, \PDO::PARAM_STR);
        $stmt->bindParam(':place_birth', $placeBirth, \PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, \PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, \PDO::PARAM_INT);
        $stmt->bindParam(':native_language', $nativeLanguage, \PDO::PARAM_STR);
        $stmt->bindParam(':second_language', $secondLanguage, \PDO::PARAM_STR);
        $stmt->bindParam(':country', $country, \PDO::PARAM_STR);
        $stmt->bindParam(':marital_status', $maritalStatus, \PDO::PARAM_INT);
        $stmt->bindParam(':passport', $passport, \PDO::PARAM_STR);
        $stmt->bindParam(':passport_place', $passportPlace, \PDO::PARAM_STR);
        $stmt->bindParam(':passport_date', $passportDate, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //查询客户基础信息
    public function queryByCustomerId($customerId) {
        $sql=sprintf('SELECT * FROM %s WHERE customer_id = :customer_id', self::tableName());
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':customer_id', $customerId, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->queryOne();
        return $ret;
    }
}
<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CustomerDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "customer";
    }

    /**
     * 新增客户
     * @param $name
     * @param $phone
     * @param $progress
     * @param $wechat
     * @param $applyCountry
     * @param $applyProject
     * @param $serviceType
     * @param $goAbroadYear
     * @param $lineBusiness
     * @param $selectCheck
     * @param $applyStatus
     * @param $visaStatus
     * @param $closeCaseStatus
     * @param $closeCaseType
     * @return int
     * @throws \yii\db\Exception
     */
    public function addCustomer($name, $phone, $progress, $wechat, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness,
                                $selectCheck, $applyStatus, $visaStatus, $closeCaseStatus, $closeCaseType) {
        $sql = sprintf('INSERT INTO %s (name, phone, progress, wechat, apply_country, apply_project, service_type, go_abroad_year,
            line_business, select_check, apply_status, visa_status, close_case_status, close_case_type, update_time, create_time)
            values (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)',
            self::tableName(), $name, $phone, $progress, $wechat, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness,
            $selectCheck, $applyStatus, $visaStatus, $closeCaseStatus, $closeCaseType);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $ret = $stmt->execute();
        return $ret;
    }

    /**
     * 查询客户
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
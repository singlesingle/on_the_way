<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class MaterialDao extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public static function tableName() {
        return "material";
    }

    public static $type = [
        1 => '签证递交回执',
        2 => '获签信',
        3 => '拒签信',
        4 => '学校申请回执',
        5 => 'offer',
        6 => '拒录信',
        7 => '其他',
    ];

    public static $typeToName = [
        '签证递交回执' => 1,
        '获签信' => 2,
        '拒签信' => 3,
        '学校申请回执' => 4,
        'offer' => 5,
        '拒录信' => 6,
        '其他' => 7,
    ];

    //新加材料
    public function addMaterial($customerId, $name, $type, $schoolId, $url) {
        $curTime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO %s (customer_id, name, type, school_id, url, create_time)
            values (%d, :name, %d, %d, :url, :create_time)",
            self::tableName(), $customerId, $type, $schoolId
        );
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $curTime, \PDO::PARAM_STR);
        $ret = $stmt->execute();
        return $ret;
    }

    //查询客户的材料列表
    public function queryByCustomerId($customerId) {
        $sql=sprintf('SELECT a.id, a.name, a.type, a.url, a.create_time, b.name as school_name FROM %s as a INNER JOIN school as b on a.school_id = b.id
        WHERE a.customer_id = %d', self::tableName(), $customerId);
        $stmt = self::getDb()->createCommand($sql);
        $stmt->prepare();
        $stmt->execute();
        $ret = $stmt->queryAll();
        return $ret;
    }
}
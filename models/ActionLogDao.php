<?php

namespace app\models;

use Yii;

class ActionLogDao extends \yii\db\ActiveRecord {

    public static function tableName() {
        return "action_log";
    }
}
?>

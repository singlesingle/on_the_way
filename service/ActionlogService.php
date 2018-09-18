<?php

namespace app\service;

use Yii;
use app\models\ActionLogDao;

class ActionlogService
{

    //录入log
    public static function WriteLog( $username,$fromip,$actionurl,$optime,$opservice,$optype,$opresult,$exectime,$oplog) {
        $logModel = new ActionLogDao();
        $logModel->username = $username;
        $logModel->fromip = $fromip;
        $logModel->actionurl = $actionurl;
        $logModel->optime = $optime;
        $logModel->opservice = $opservice;
        $logModel->optype = $optype;
        $logModel->opresult = $opresult;
        $logModel->exectime = $exectime;
        $logModel->oplog = $oplog;

        return $logModel->insert();
    }

    public static function getOpService() {
        $cache_key = "logOpService";
        $servicelist = Yii::$app->cache->get( $cache_key );
        if ( !$servicelist ) {
            $slist = ActionLogDao::findBySql("select distinct(opservice) from actionlog")->asArray()->all();
            $servicelist = [];
            foreach( $slist as $k=>$v) {
                $servicelist[] = $v['opservice'];
            }
            Yii::$app->cache->set( $cache_key, $servicelist,3600);
        }
        return $servicelist;
    }

    public static function SearchLogs( $user,$ip,$duixiang, $caozuo, $jieguo, $begin, $endt, $keywd) {
        $logObj = ActionLogDao::find()->orderBy('optime desc');
        if ( $user ) {
            $logObj->andWhere(['username' => $user]);
        }
        if ( $ip ) {
            $logObj->andWhere('fromip like "%:ip%"',[':ip'=>$ip]);
        }
        if ( $duixiang ) {
            $logObj->andWhere(['opservice'=>$duixiang]);
        }
        if ( $caozuo ) {
            $logObj->andWhere(['optype'=>$caozuo]);
        }
        if ( $jieguo ) {
            $logObj->andWhere(['opresult'=>$jieguo]);
        }
        if ( $keywd ) {
            $logObj->andWhere('oplog like :key',[':key'=>'%'.$keywd.'%']);
        }
        $logObj->andWhere('optime > :begin and optime < :end',[':begin'=>$begin,':end'=>$endt]);
        return $logObj->limit(1000)->asArray()->all();
    }
}

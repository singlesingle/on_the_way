<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller {
    public function actionError() {
    	$exception = Yii::$app->errorHandler->exception;
        Yii::getLogger()->log($exception);
        //如果输入错误的路由，返回404状态码
        if($exception->statusCode == 404){
            return $this->redirect('/404')->send();
        }
        return $this->redirect('/500')->send();
    }
}

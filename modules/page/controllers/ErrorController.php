<?php

namespace app\modules\page\controllers;


use yii\web\Controller;

class ErrorController extends Controller
{
    public function actionError403(){
        return $this->render('403.tpl');
    }

    public function actionError404(){
        return $this->render('404.tpl');
    }
    public function actionError500(){
        return $this->render('500.tpl');
    }
}

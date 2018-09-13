<?php

namespace app\modules\page\controllers;

use Yii;
use app\service\db\ActionlogService;
use app\classes\BaseController;

class ActionlogController extends BaseController
{

    /**
     * 操作审计
     * @return string
     */
    public function actionIndex()
    {
        $this->data['active_page'] = 'actionlog';
        $this->data['page_topo'] = 'actionlog';

        $servicelist = ActionlogService::getOpService();
        $this->data['opservice'] = $servicelist;
        $this->data['starttime'] = Yii::$app->request->get('begintime',date("Y-m-d H:i:s",time()-60*60*24));
        $this->data['endtime'] = Yii::$app->request->get('endtime',date("Y-m-d H:i:s"));
        $this->data['username'] = Yii::$app->request->get('nameinput');
        $this->data['fromip'] = Yii::$app->request->get('ipinput');
        $this->data['duixianginput'] = Yii::$app->request->get('duixianginput');
        $this->data['caozuoinput'] = Yii::$app->request->get('caozuoinput');
        $this->data['jieguoinput'] = Yii::$app->request->get('jieguoinput');
        $this->data['logkeywd'] = Yii::$app->request->get('logkeywd');
        $this->data['loglist'] = array();

        if( count(Yii::$app->request->get()) > 0) {
            $loglist = ActionlogService::SearchLogs(Yii::$app->request->get('nameinput'),Yii::$app->request->get('ipinput'),Yii::$app->request->get('duixianginput'),Yii::$app->request->get('caozuoinput'),Yii::$app->request->get('jieguoinput'),Yii::$app->request->get('begintime',date("Y-m-d H:i:s",time()-60*60)),Yii::$app->request->get('endtime',date("Y-m-d H:i:s")),Yii::$app->request->get('logkeywd'));
            $this->data['loglist'] = $loglist;
        }

        return $this->render('index.tpl', $this->data);
    }
}

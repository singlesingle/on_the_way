<?php

namespace app\modules\page\controllers;

use app\service\cron\ServerService;
use app\service\domain\LjnodeService;
use Yii;
use app\service\db\SentryService;
use app\service\DnspodService;
use app\classes\BaseController;

class DesktopController extends BaseController
{

    /**
     * 首页
     * @return string
     */
    public function actionInfo()
    {
        $this->data['page_topo'] = 'desktop';
        return $this->render('info.tpl', $this->data);
    }
}

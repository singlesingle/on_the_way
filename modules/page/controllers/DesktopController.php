<?php

namespace app\modules\page\controllers;

use app\models\CustomerDao;
use app\service\cron\ServerService;
use app\service\CustomerService;
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
        $userId = $this->data['user_id'];
        $role = $this->data['role'];
        $customerService = new CustomerService();
        $customerStatistic = $customerService->customerStatistic($userId, $role);
        $this->data['page_topo'] = 'desktop';
        $this->data['customer_statistic'] = $customerStatistic;
        return $this->render('info.tpl', $this->data);
    }
}

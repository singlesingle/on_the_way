<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Util;
use app\models\CustomerDao;
use app\service\BasicInfoService;
use app\service\CaseService;
use app\service\CustomerService;
use app\service\EducationService;
use app\service\FileService;
use app\service\MaterialService;
use Yii;

class CustomerController extends BaseController
{
    //创建客户
    public function actionAdd()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'contract_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'phone' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_country' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_project' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'service_type' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'go_abroad_year' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'wechat' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $name = $this->getParam('name', '');
        $contractId = $this->getParam('contract_id', '');
        $phone = $this->getParam('phone', '');
        $applyCountry = $this->getParam('apply_country', '');
        $applyProject = $this->getParam('apply_project', 0);
        $serviceType = $this->getParam('service_type', '');
        $goAbroadYear = $this->getParam('go_abroad_year', '');
        $wechat = $this->getParam('wechat', '');
        $userId = $this->data['user_id'];
        $customerService = new CustomerService();
        $ret = $customerService->addCustomer($userId, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $wechat);
        $this->actionLog(self::LOGADD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //修改客户信息
    public function actionUpdate()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'contract_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'phone' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_country' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'apply_project' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'service_type' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'go_abroad_year' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'line_business' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'wechat' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'communication' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $id = $this->getParam('id', '');
        $name = $this->getParam('name', '');
        $contractId = $this->getParam('contract_id', '');
        $phone = $this->getParam('phone', '');
        $applyCountry = $this->getParam('apply_country', '');
        $applyProject = $this->getParam('apply_project', 0);
        $serviceType = $this->getParam('service_type', '');
        $goAbroadYear = $this->getParam('go_abroad_year', '');
        $lineBusiness = $this->getParam('line_business', '');
        $wechat = $this->getParam('wechat', '');
        $communication = $this->getParam('communication', '');
        $customerService = new CustomerService();
        $ret = $customerService->updateCustomer($id, $name, $contractId, $phone, $applyCountry, $applyProject, $serviceType, $goAbroadYear, $lineBusiness, $wechat, $communication);
        $this->actionLog(self::LOGMOD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //我的客户列表
    public function actionList() {
        $this->defineMethod = 'GET';
        $this->defineParams = array (
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $userId = $this->data['user_id'];
        $role = $this->data['role'];
        $customerService = new CustomerService();
        $customerList = $customerService->customerList($userId, $role);
        $list = [];
        foreach ($customerList as $customer) {
            $one = [];
            $one['id'] = $customer['id'];
            $one['text'] = $customer['name'] . '：' .$customer['apply_project'];
            $list[] = $one;
        }
        $data['results'] = $list;
        $error = ErrorDict::getError(ErrorDict::SUCCESS);
        $ret = $this->outputJson($data, $error);
        return $ret;
    }

    //查询客户列表
    public function actionSearchlist() {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'apply_country' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'apply_project' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'service_type' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'go_abroad_year' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'apply_status' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'visa_status' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'close_case_status' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'aoData' => array(
                'require' => true,
                'checker' => 'noCheck',
            ),
            'page' => array(
                'require' => true,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $applyCountry = $this->getParam('apply_country', '');
        $applyProject = $this->getParam('apply_project', '');
        $serviceType = $this->getParam('service_type', '');
        $goAbroadYear = $this->getParam('go_abroad_year', '');
        $applyStatus = $this->getParam('apply_status', '');
        $visaStatus = $this->getParam('visa_status', '');
        $closeCaseStatus = $this->getParam('close_case_status', '');
        $aoData = $this->getParam('aoData', '');
        $page = $this->getParam('page');
        $iDisplayStart = 0; // 起始索引
        $iDisplayLength = 10;//分页长度
        $json = json_decode($aoData) ;
        foreach($json as $value){
            if($value->name == "sEcho"){
                $sEcho = $value->value;
            }
            if($value->name == "iDisplayStart"){
                $iDisplayStart = $value->value;
            }
            if($value->name == "iDisplayLength"){
                $iDisplayLength = $value->value;
            }
        }
        $userId = $this->data['user_id'];
        $role = $this->data['role'];
        $customerList = array();
        $customerService = new CustomerService();
        $list = $customerService->queryCustomerList($applyCountry, $applyProject, $serviceType, $goAbroadYear,
            $applyStatus, $visaStatus, $closeCaseStatus, $iDisplayStart, $iDisplayLength, $userId, $role);
        if ($list) {
            $count = count($list);
            foreach ($list as $one) {
                $data = [];
                $data[] = $one['name'];
                $data[] = $one['contract_id'];
                $data[] = $one['phone'];
                $data[] = $one['apply_country'];
                $data[] = $one['apply_project'];
                $data[] = $one['service_type'];
                $data[] = $one['go_abroad_year'];
                $data[] = $one['wechat'];
                $data[] = $one['apply_status'];
                $data[] = $one['visa_status'];
                $data[] = $one['close_case_status'];
                $data[] = "<a type=\"button\" class=\"btn btn-sm btn-danger\" href=\"/page/customer/info?id={$one['id']}\">查看</a>";
                $customerList[] = $data;
            }
        }else {
            $customerList = [];
            $count = 0;
        }
        $json_data = array ('sEcho'=>$sEcho,'iTotalRecords'=>$count,'iTotalDisplayRecords'=>$count,'aaData'=>$customerList);  //按照datatable的当前页和每页长度返回json数据
        $obj=json_encode($json_data, JSON_UNESCAPED_UNICODE);
        echo $obj;
    }

    //保存客户基本信息
    public function actionSavebasicinfo()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'name_pinyin' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'english_name' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'used_name' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'id_number' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'email' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'landline_number' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'address' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'zip_code' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'mail_address' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'mail_zip_code' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'place_birth' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'birthday' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'gender' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'native_language' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'second_language' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'country' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'marital_status' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'passport' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'passport_place' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'passport_date' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $id = $this->getParam('id', '');
        $namePinyin = $this->getParam('name_pinyin', '');
        $englishName = $this->getParam('english_name', '');
        $usedName = $this->getParam('used_name', '');
        $idNumber = $this->getParam('id_number', '');
        $email = $this->getParam('email', 0);
        $landlineNumber = $this->getParam('landline_number', '');
        $address = $this->getParam('address', '');
        $zipCode = $this->getParam('zip_code', '');
        $mailAddress = $this->getParam('mail_address', '');
        $mailZipCode = $this->getParam('mail_zip_code', '');
        $placeBirth = $this->getParam('place_birth', '');
        $birthday = $this->getParam('birthday', '');
        $gender = $this->getParam('gender', '');
        $nativeLanguage = $this->getParam('native_language', '');
        $secondLanguage = $this->getParam('second_language', '');
        $country = $this->getParam('country', 0);
        $maritalStatus = $this->getParam('marital_status', '');
        $passport = $this->getParam('passport', '');
        $passportPlace = $this->getParam('passport_place', '');
        $passportDate = $this->getParam('passport_date', '');
        $basicInfoService = new BasicInfoService();
        $ret = $basicInfoService->saveBasicInfo($id, $namePinyin, $englishName, $usedName, $idNumber, $email, $landlineNumber, $address,
            $zipCode, $mailAddress, $mailZipCode, $placeBirth, $birthday, $gender, $nativeLanguage, $secondLanguage,
            $country, $maritalStatus, $passport, $passportPlace, $passportDate);
        $this->actionLog(self::LOGMOD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //新增材料
    public function actionAddmaterial()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'name' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'type' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'customer_id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'school_id' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $customerId = $this->getParam('customer_id', '');
        $name = $this->getParam('name', '');
        $type = $this->getParam('type', '');
        $schoolId = $this->getParam('school_id', '');
        $filePath = $_FILES["file"]["tmp_name"];
        $fileName = $_FILES["file"]["name"];
        $fileService = new FileService();
        $url = $fileService->uploadFile($filePath, $fileName);
        if (!$url) {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('上传文件失败', $error);
            return $ret;
        }
        $userId = $this->data['user_id'];
        $materialService = new MaterialService();
        $ret = $materialService->addMaterial($userId, $customerId, $name, $type, $schoolId, $url);
        $this->actionLog(self::LOGADD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }

    //保存客户教育信息
    public function actionSaveeducation()
    {
        $this->defineMethod = 'POST';
        $this->defineParams = array (
            'id' => array (
                'require' => true,
                'checker' => 'noCheck',
            ),
            'start_time' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'end_time' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'major' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'level' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'address' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'school_name' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'rank' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'type' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'school_web' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
            'phone' => array (
                'require' => false,
                'checker' => 'noCheck',
            ),
        );
        if (false === $this->check()) {
            $ret = $this->outputJson(array(), $this->err);
            return $ret;
        }
        $id = $this->getParam('id', '');
        $startTime = $this->getParam('start_time', '');
        $endTime = $this->getParam('end_time', '');
        $level = $this->getParam('level', '');
        $major = $this->getParam('major', '');
        $address = $this->getParam('address', 0);
        $schoolName = $this->getParam('school_name', '');
        $rank = $this->getParam('rank', '');
        $type = $this->getParam('type', '');
        $schoolWeb = $this->getParam('school_web', '');
        $phone = $this->getParam('phone', '');
        $educationService = new EducationService();
        $ret = $educationService->saveEducation($id, $startTime, $endTime, $major, $level, $address, $schoolName,
            $rank, $type, $schoolWeb, $phone);
        $this->actionLog(self::LOGMOD, $ret ? self::OPOK : self::OPFAIL, $this->params);
        if ($ret) {
            $error = ErrorDict::getError(ErrorDict::SUCCESS);
            $ret = $this->outputJson('', $error);
        }else {
            $error = ErrorDict::getError(ErrorDict::G_SYS_ERR);
            $ret = $this->outputJson('', $error);
        }
        return $ret;
    }
}
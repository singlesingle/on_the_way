<?php

namespace app\modules\api\controllers;

use app\classes\BaseController;
use app\classes\ErrorDict;
use app\classes\Util;
use app\models\BasicInfoDao;
use app\models\CustomerDao;
use app\models\EducationDao;
use app\models\MaterialDao;
use app\models\SchoolDao;
use app\models\UserDao;
use app\service\BasicInfoService;
use app\service\CaseService;
use app\service\CustomerService;
use app\service\EducationService;
use app\service\FileService;
use app\service\MaterialService;
use app\service\SchoolService;
use app\service\UserService;
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
            'consultant' => array (
                'require' => false,
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
        $consultant = $this->getParam('consultant', '');
        $userId = $this->data['user_id'];
        $customerService = new CustomerService();
        $ret = $customerService->addCustomer($userId, $name, $contractId, $phone, $applyCountry, $applyProject,
            $serviceType, $goAbroadYear, $wechat, $consultant);
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

    //定时任务，客户状态变更
    public function actionStatus() {
        echo '开始执行';
        $customerDao = new CustomerDao();
        $basicInfoDao = new BasicInfoDao();
        $materialDao = new MaterialDao();
        $schoolDao = new SchoolDao();
        $educationDao = new EducationDao();
        $customerList = $customerDao->queryAllList();
        foreach ($customerList as $customer) {
            //申请状态，判断是否需要从“未开始”变为“申请中”
            //客户申请材料已收齐（客户基础信息、教育背景、留学材料），状态变为申请中
            if ($customer['apply_status'] == CustomerDao::$applyStatusDict['未开始']) {
                $basicInfo = $basicInfoDao->queryByCustomerId($customer['id']);
                if ($basicInfo && $basicInfo['id_number'] && $basicInfo['email'] && $basicInfo['mail_address']
                    && $basicInfo['birthday'] && $basicInfo['gender'] && $basicInfo['passport']){
                    $educationInfo = $educationDao->queryByCustomerId($customer['id']);
                    if ($educationInfo && $educationInfo['school_name']) {
                        $materialList = $materialDao->queryByCustomerId($customer['id']);
                        if (count($materialList) > 0) {
                            $customerDao->updateApplyStatus($customer['id'], CustomerDao::$applyStatusDict['申请中']);
                            echo "客户{$customer['id']}申请状态变为申请中";
                        }
                    }
                }
            }
            //申请状态，判断是否需要从“申请中”变为“已完成”
            //所有申请学校，全部有个结果，状态变为已完成
            elseif ($customer['apply_status'] == CustomerDao::$applyStatusDict['申请中']) {
                $over = true;
                $schoolList = $schoolDao->queryById($customer['id']);
                foreach ($schoolList as $school) {
                    if ($school['apply_status'] == SchoolDao::$applyStatusName['录取'] || $school['apply_status'] == SchoolDao::$applyStatusName['未录取']
                        || $school['apply_status'] == SchoolDao::$applyStatusName['确认入读']) {
                        continue;
                    }else {
                        $over = false;
                        break;
                    }
                }
                if ($over) {
                    $customerDao->updateApplyStatus($customer['id'], CustomerDao::$applyStatusDict['已完成']);
                    echo "客户{$customer['id']}申请状态变为已完成";
                }
            }

            //结案状态，判断是否需要从“未结案”变为“已结案”
            //学生签证有结果，申请学校全部有结果状态变为已结案
            if  ($customer['close_case_status'] == CustomerDao::$closeCaseStatusDict['未结案']) {
                if ($customer['visa_status'] == CustomerDao::$visaStatusDict['获签']
                    || $customer['visa_status'] == CustomerDao::$visaStatusDict['拒签']) {
                    $over = true;
                    $schoolList = $schoolDao->queryById($customer['id']);
                    foreach ($schoolList as $school) {
                        if ($school['apply_status'] == SchoolDao::$applyStatusName['录取'] || $school['apply_status'] == SchoolDao::$applyStatusName['未录取']
                            || $school['apply_status'] == SchoolDao::$applyStatusName['确认入读']) {
                            continue;
                        }else {
                            $over = false;
                            break;
                        }
                    }
                    if ($over) {
                        $customerDao->updateCloseCaseStatus($customer['id'], CustomerDao::$closeCaseStatusDict['已结案']);
                        echo "客户{$customer['id']}已结案";
                    }
                }
            }
        }
    }

    //批量录入客户信息
    public function actionBatchadd()
    {
        $role = $this->params['role'];
        if ($role == UserDao::$role['文案人员']) {
            $error = ErrorDict::getError(ErrorDict::G_POWER);
            $ret = $this->outputJson('对不起，您无权限！', $error);
            return $ret;
        }
        $filePath = $_FILES["file"]["tmp_name"];
        $uploadName = $_FILES["files"]["name"];
//        $pattern = "/^(.*)+(.xls|.xlsx)$/";
//        if (!preg_match($pattern, $uploadName)) {
//            $error = ErrorDict::getError(ErrorDict::G_PARAM, '文件格式错误', '文件格式错误');
//            $ret = $this->outputJson('', $error);
//            return $ret;
//        }
        $reader = \PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
        $PHPExcel = $reader->load($filePath); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = 'S'; // 取得总列数
        $userService = new UserService();
        $nameToId = [];
        $userList = $userService->userListByRole(UserDao::$role['文案人员']);
        foreach ($userList as $user) {
            $nameToId[$user['name']] = $user['id'];
        }
        $customerService = new CustomerService();
        $schoolService = new SchoolService();
        for ($row = 2; $row <= $highestRow; $row++) {//行数是以第2行开始
            $continue = true;
            list($applyCountry, $serviceType, $consultant, $userName, $studentName, $applySchools, $applyProfessions, $applyProject, $admissionTime, $applyStatus, $visaStatus, $remark) = '';
            for ($column = 'B'; $column <= $highestColumn; $column++) {
                $value = $sheet->getCell($column.$row)->getValue();
                switch ($column) {
                    case 'B':
                        $applyCountry = trim($value);
                        break;
                    case 'C':
                        $serviceType = trim($value);
                        break;
                    case 'D':
                        $consultant = trim($value);
                        break;
                    case 'E':
                        $userName = trim($value);
                        break;
                    case 'F':
                        $studentName = trim($value);
                        if (empty($studentName)) {
                            $continue = false;
                        }
                        break;
                    case 'G':
                        $applySchools = trim($value);
                        break;
                    case 'H':
                        $applyProfessions = trim($value);
                        break;
                    case 'I':
                        $applyProject = trim($value);
                        break;
                    case 'J':
                        $admissionTime = trim($value);
                        break;
                    case 'K':
                        $applyStatus = trim($value);
                        break;
                    case 'L':
                        $visaStatus = trim($value);
                        break;
                    case 'M':
                        $remark = trim($value);
                        break;
                }
                if ($continue == false) {
                    break;
                }
            }
            if ($continue == false) {
                if ($row == 2) {
                    $error = ErrorDict::getError(ErrorDict::G_PARAM, '文件数据为空', '文件数据为空');
                    $ret = $this->outputJson('', $error);
                    return $ret;
                }
                break;
            }
            $rowMessage = '第' . $row . '行，客户' . $studentName . ':';

            //判断客户是否已存在，只依照名字，名字重复的不支持自动录取，如需录取请手动
            $customerInfo = $customerService->queryByName($studentName);
            if ($customerInfo) {
                $error = ErrorDict::getError(ErrorDict::G_PARAM, '学生姓名已录入', $rowMessage . '学生姓名已录入，如需重复');
                $ret = $this->outputJson('', $error);
                return $ret;
            }

            //判断文案人员是否已录入系统
            if(!isset($nameToId[$userName])) {
                $error = ErrorDict::getError(ErrorDict::G_PARAM, '文案人员未录入', $rowMessage . '文案人员未录入');
                $ret = $this->outputJson('', $error);
                return $ret;
            }
            $userId = $nameToId[$userName];

            //判断申请项目
            $applyProjectId = 0;
            if (strstr($applyProject, '初中')) {
                $applyProjectId = CustomerDao::$applyProjectDict['初中'];
            }elseif (strstr($applyProject, '高中')) {
                $applyProjectId = CustomerDao::$applyProjectDict['高中'];
            }elseif (strstr($applyProject, '本科')) {
                $applyProjectId = CustomerDao::$applyProjectDict['本科'];
            }elseif (strstr($applyProject, '硕士')) {
                $applyProjectId = CustomerDao::$applyProjectDict['硕士'];
            }

            //判断服务类型
            $serviceTypeId = 0;
            if (strstr($serviceType, '文书')) {
                $serviceTypeId = CustomerDao::$serviceTypeDict['单文书'];
            }elseif (strstr($serviceType, '全程')) {
                $serviceTypeId = CustomerDao::$serviceTypeDict['全程服务'];
            }elseif (strstr($serviceType, '单申请')) {
                $serviceTypeId = CustomerDao::$serviceTypeDict['单申请'];
            }elseif (strstr($serviceType, '签证')) {
                $serviceTypeId = CustomerDao::$serviceTypeDict['签证'];
            }

            //判断出国年限
            $goAbroadYear = '';
            if (strlen($admissionTime) >= 4) {
                $year = substr($admissionTime, 0, 4);
                if (intval($year) < 3000) {
                    $goAbroadYear = $year;
                }
            }

            //判断申请状态
            $applyStatusId = 0;
            if (strstr($applyStatus, '录取')) {
                $applyStatusId = SchoolDao::$applyStatusName['录取'];
            }elseif (strstr($applyStatus, '拒')) {
                $applyStatusId = SchoolDao::$applyStatusName['未录取'];
            }

            //判断签证状态
            $visaStatusId = 0;
            if (strstr($visaStatus, '获签')) {
                $visaStatusId = CustomerDao::$visaStatusDict['获签'];
            }elseif (strstr($visaStatus, '拒签')) {
                $visaStatusId = CustomerDao::$visaStatusDict['拒签'];
            }

            //录入客户信息
            $customerId = $customerService->addCustomer($userId, $studentName, '', '', $applyCountry,
                $applyProjectId, $serviceTypeId, $goAbroadYear, '', $consultant);

            //更新客户备注信息
            $customerService->updateRemark($customerId, $remark);

            //更新客户签证状态
            if ($visaStatusId) {
                $customerService->updateVisaStatus($customerId, $visaStatusId);
            }

            //判断客户申报学校
            if ($applySchools && !strstr($applySchools, '定校')) {
                $applySchoolArr = explode(',', str_replace(array('，'), ',', $applySchools));
                $applyProfessionArr = explode(',', str_replace(array('，', '&'), ',', $applyProfessions));
                foreach ($applySchoolArr as $schoolName) {
                    $schoolId = $schoolService->addSchool($customerId, $schoolName, '', '', $admissionTime);
                    //更新学校申请状态
                    if ($applyStatusId) {
                        $schoolService->updateApplyStatus($schoolId, $applyStatusId);
                    }
                    if (count($applySchoolArr) > 0) {
                        foreach ($applyProfessionArr as $profession) {
                            //添加申请专业
                            $schoolService->addProfession($schoolId, '', $profession, '', '', '', '', '', '');
                        }
                    }
                }
            }
        }
        $this->actionLog(self::LOGADD, self::OPOK, $this->params);
        $error = ErrorDict::getError(ErrorDict::SUCCESS);
        $ret = $this->outputJson('', $error);
        return $ret;
    }
}
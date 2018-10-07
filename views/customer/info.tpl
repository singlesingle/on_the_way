{include "layout/header.tpl"}

<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/static/css/jquery.datetimepicker.css"/>
<link href="/static/bk/css/bk_app_theme.css" rel="stylesheet" type="text/css" />
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bk.css?v=1.0.1"/>
<link rel="stylesheet" href="/static/assets/kendoui-2015.2.624/styles/kendo.common.min.css"/>
<link rel="stylesheet" href="/static/assets/kendoui-2015.2.624/styles/kendo.default.min.css"/>
<link rel="stylesheet" href="/static/assets/artDialog-6.0.4/css/ui-dialog.css"/>
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/select2-3.5.2/select2.css" rel="stylesheet">
<script src="/static/assets/js/jquery-1.10.2.min.js"></script>
<script src="/static/assets/artDialog-6.0.4/dist/dialog-min.js"></script>
<script src="/static/assets/validate1.14.0/js/jquery.validate.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/select2-3.5.2/select2.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/jquery.dataTables.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/dataTables.bootstrap.js"></script>
<script src="/static/js/select2/select2.js"></script>
<link href="/static/js/select2/select2.css" rel="stylesheet">
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/daterangepicker.css" rel="stylesheet">

<div class="col-lg-12">
    {*<div class="row">*}
        {*<div class="col-lg-12">*}
            {*<div class="alert alert-success bootstrap-admin-alert">*}
                {*<h4>客户详细信息</h4>*}
            {*</div>*}
        {*</div>*}
    {*</div>*}
    <div class="tab-box" id="myTab3">
        <h4>客户详细信息</h4>
        <ul class="nav nav-tabs king-nav-tabs2  king-tab-success">
            <li class="active">
                <a href="#tab3_1" data-toggle="tab">学生信息</a>
            </li>
            <li>
                <a href="#tab3_2" data-toggle="tab">教育背景</a>
            </li>
            <li>
                <a href="#tab3_3" data-toggle="tab">选校</a>
            </li>
            <li>
                <a href="#tab3_4" data-toggle="tab">留学材料</a>
            </li>
            {*<li>*}
                {*<a href="#tab3_5" data-toggle="tab">申请进度</a>*}
            {*</li>*}
            {*<li>*}
                {*<a href="#tab3_6" data-toggle="tab">签证进度</a>*}
            {*</li>*}
        </ul>
        <div class="tab-content mb20">
            <div class="tab-pane active" id="tab3_1">
                <form class="form-horizontal ng-scope ng-invalid ng-invalid-required ng-valid-pattern ng-valid-email ng-valid-date ng-pristine"  novalidate="" style="margin-top: 20px;">
                    <div class="row basic-form col-md-10 col-lg-offset-1" >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"> 中文名</label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" id="name" placeholder="请与护照一致" required="" style="" value="{$customer_info['name']}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"> 中文名拼音</label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required ng-valid-pattern" ng-pattern="/^[A-Z]+$/" placeholder="请与护照一致" id="name_pinyin" value="{$basic_info['name_pinyin']}" ng-change="console.info(11)" required=""> <!-- ngIf: myFormBasic.name_pinyin.$error.pattern && myFormBasic.$submitted==true --> <!-- ngIf: myFormBasic.name_pinyin.$error.required && myFormBasic.$submitted==true --> </div> </div> <div class="form-group">
                                <label class="col-sm-3 control-label pt0">英文名</label> <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" placeholder="请与护照一致" id="english_name" value="{$basic_info['english_name']}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">曾用名</label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" id="used_name" value="{$basic_info['used_name']}"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 身份证号码</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid-pattern ng-not-empty ng-valid ng-valid-required" ng-pattern="/(^\d{15}$)|(^\d{17}(\d|X)$)/" ng-change="$info.changeIdentityNum($info.basic.identity_number)" id="id_number" value="{$basic_info['id_number']}" required="" style=""> <!-- ngIf: myFormBasic.identity_number.$error.pattern && myFormBasic.$submitted==true --> <!-- ngIf: myFormBasic.identity_number.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 手机号码</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid-pattern ng-not-empty ng-valid ng-valid-required" ng-pattern="/^(((1[345789][\d][0-9]{8}))(|\+\d))$/" id="phone" value="{$customer_info['phone']}" required="" style=""> <!-- ngIf: myFormBasic.mobile.$error.pattern && myFormBasic.$submitted==true --> <!-- ngIf: myFormBasic.mobile.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group"> <label class="col-sm-3 control-label"> 电子邮箱</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control ng-pristine ng-untouched ng-valid ng-valid-email ng-not-empty" id="email" value="{$basic_info['email']}" style=""> <!-- ngIf: myFormBasic.email.$error.email && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">座机号码</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" id="landline_number" value="{$basic_info['landline_number']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">家庭住址</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" placeholder="此地址用于网申，非常重要，具体到门牌号" id="address" value="{$basic_info['address']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">家庭住址邮编</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" id="zip_code" value="{$basic_info['zip_code']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">通讯住址</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" placeholder="此地址用于接收录取通知书，非常重要，具体到门牌号" id="mail_address" value="{$basic_info['mail_address']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">通讯地址邮编</label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" ng-pattern="/^[0-9]\d{5}$/" id="mail_zip_code" value="{$basic_info['mail_zip_code']}"> <!-- ngIf: myFormBasic.mailing_addr_postcode.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 出生地</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" id="place_birth" value="{$basic_info['place_birth']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"> 出生日期</label>
                                <div class="col-sm-9">
                                    <div class="date-time">
                                        <input type="text" class="form-control" id="birthday" name="begintime" value="{$basic_info['birthday']}" style="width:300px;">
                                        <div uib-datepicker-popup-wrap="" ng-model="date" ng-change="dateSelection(date)" template-url="uib/template/datepickerPopup/popup.html" class="ng-pristine ng-untouched ng-valid ng-scope ng-not-empty" style=""><!-- ngIf: isOpen --></div>
                                    </div> <!-- ngIf: myFormBasic.birthday.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 性别</label>
                                <div class="col-sm-9">
                                    <select id="gender" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-options="Gender.name as Gender.name for Gender in $info.Gender" required="">
                                        {if {$basic_info['gender']} == ''}
                                            <option value="" class="" selected="selected">请选择</option>
                                        {else}
                                            <option value="" class="">请选择</option>
                                        {/if}
                                        {if {$basic_info['gender']} == 1}
                                            <option value="1" class="" selected="selected">男</option>
                                        {else}
                                            <option value="1" class="">男</option>
                                        {/if}
                                        {if {$basic_info['gender']} == 2}
                                            <option value="2" class="" selected="selected">女</option>
                                        {else}
                                            <option value="2" class="">女</option>
                                        {/if}
                                    </select> <!-- ngIf: myFormBasic.sex.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 母语</label>
                                <div class="col-sm-9">
                                    <select id="native_language" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-model="$info.basic.native_language" ng-options="options.name as options.name for options in $info.Languages" required="">
                                        {if {$basic_info['native_language']} == ''}
                                            <option value="" class="" selected="selected">请选择</option>
                                        {else}
                                            <option value="" class="">请选择</option>
                                        {/if}
                                        {if {$basic_info['native_language']} == '汉语'}
                                            <option value="汉语" class="" selected="selected">汉语</option>
                                        {else}
                                            <option value="汉语" class="">汉语</option>
                                        {/if}
                                        {if {$basic_info['native_language']} == '英语'}
                                            <option value="英语" class="" selected="selected">英语</option>
                                        {else}
                                            <option value="英语" class="">英语</option>
                                        {/if}
                                        {if {$basic_info['native_language']} == '法语'}
                                            <option value="法语" class="" selected="selected">法语</option>
                                        {else}
                                            <option value="法语" class="">法语</option>
                                        {/if}
                                        {if {$basic_info['native_language']} == '俄语'}
                                            <option value="俄语" class="" selected="selected">俄语</option>
                                        {else}
                                            <option value="俄语" class="">俄语</option>
                                        {/if}
                                    </select> <!-- ngIf: myFormBasic.native_language.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">第二语言</label> <div class="col-sm-9">
                                    <select id="second_language" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="$info.basic.second_language" ng-options="options.name as options.name for options in $info.Languages">
                                        {if {$basic_info['second_language']} == ''}
                                            <option value="" class="" selected="selected">请选择</option>
                                        {else}
                                            <option value="" class="">请选择</option>
                                        {/if}
                                        {if {$basic_info['second_language']} == '汉语'}
                                            <option value="汉语" class="" selected="selected">汉语</option>
                                        {else}
                                            <option value="汉语" class="">汉语</option>
                                        {/if}
                                        {if {$basic_info['second_language']} == '英语'}
                                            <option value="英语" class="" selected="selected">英语</option>
                                        {else}
                                            <option value="英语" class="">英语</option>
                                        {/if}
                                        {if {$basic_info['second_language']} == '法语'}
                                            <option value="法语" class="" selected="selected">法语</option>
                                        {else}
                                            <option value="法语" class="">法语</option>
                                        {/if}
                                        {if {$basic_info['second_language']} == '俄语'}
                                            <option value="俄语" class="" selected="selected">俄语</option>
                                        {else}
                                            <option value="俄语" class="">俄语</option>
                                        {/if}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 国籍</label>
                                <div class="col-sm-9"> <div>
                                        <div on="type" ng-switch="" class="ss-dmc-control ng-pristine ng-untouched ng-isolate-scope ng-not-empty ng-valid ng-valid-required" type="'select'" code="'region_load_countries'" ng-model="$info.basic.nationality" required="required" style=""> <!-- ngSwitchWhen: select -->
                                            <select id='country' ng-switch-when="select" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-not-empty" style="">
                                                {if {$basic_info['country']} == ''}
                                                    <option value="" class="" selected="selected">请选择</option>
                                                {else}
                                                    <option value="" class="">请选择</option>
                                                {/if}
                                                {if {$basic_info['country']} == '中国'}
                                                    <option label="中国" value="中国" selected="selected">中国</option>
                                                {else}
                                                    <option label="中国" value="中国">中国</option>
                                                {/if}
                                                {if {$basic_info['country']} == '中国香港'}
                                                    <option label="中国香港" value="中国香港" selected="selected">中国香港</option>
                                                {else}
                                                    <option label="中国香港" value="中国香港">中国香港</option>
                                                {/if}
                                                {if {$basic_info['country']} == '中国澳门'}
                                                    <option label="中国澳门" value="中国澳门" selected="selected">中国澳门</option>
                                                {else}
                                                    <option label="中国澳门" value="中国澳门">中国澳门</option>
                                                {/if}
                                                {if {$basic_info['country']} == '韩国'}
                                                    <option label="韩国" value="韩国" selected="selected">韩国</option>
                                                {else}
                                                    <option label="韩国" value="韩国">韩国</option>
                                                {/if}
                                                {if {$basic_info['country']} == '日本'}
                                                    <option label="日本" value="日本" selected="selected">日本</option>
                                                {else}
                                                    <option label="日本" value="日本">日本</option>
                                                {/if}
                                                {if {$basic_info['country']} == '美国'}
                                                    <option label="美国" value="美国" selected="selected">美国</option>
                                                {else}
                                                    <option label="美国" value="美国">美国</option>
                                                {/if}
                                            </select><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi --> </div> <!-- ngIf: myFormBasic.nationality.$error.required && myFormBasic.$submitted==true --> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">婚姻状况</label>
                                <div class="col-sm-9">
                                    <select id="marital_status" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="$info.basic.marital_status" ng-options="options.name as options.name for options in $info.Marriage">
                                        {if {$basic_info['marital_status']} == 1}
                                            <option value="" class="" selected="selected">请选择</option>
                                        {else}
                                            <option value="" class="">请选择</option>
                                        {/if}
                                        {if {$basic_info['marital_status']} == 1}
                                            <option label="已婚" value="1" selected="selected">已婚</option>
                                        {else}
                                            <option label="已婚" value="1" >已婚</option>
                                        {/if}
                                        {if {$basic_info['marital_status']} == 2}
                                            <option label="未婚" value="2" selected="selected">未婚</option>
                                        {else}
                                            <option label="未婚" value="2">未婚</option>
                                        {/if}
                                        {if {$basic_info['marital_status']} == 3}
                                            <option label="离异" value="3" selected="selected">离异</option>
                                        {else}
                                            <option label="离异" value="3">离异</option>
                                        {/if}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">   最新护照号码 <br>
                                </label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="如果没有请填无" id="passport" value="{$basic_info['passport']}" required=""> <!-- ngIf: myFormBasic.passport_number.$error.required && myFormBasic.$submitted==true --> </div> </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">护照签发地</label>
                                <div class="col-sm-9"> <input ng-model="$info.basic.passport_issuing_city" type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" id="passport_place" value="{$basic_info['passport_place']}"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">护照有效期</label>
                                <div class="col-sm-9">
                                    <div class="date-time">
                                        <input type="text" class="form-control" id="passport_date" name="passport_date" value="{$basic_info['passport_date']}" style="width:300px;">
                                        <div uib-datepicker-popup-wrap="" ng-model="date" ng-change="dateSelection(date)"  class="ng-pristine ng-untouched ng-valid ng-scope ng-empty"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- ngIf: $info.immigration.length -->
                    <div class="row">
                        <div class="form-group text-center col-sm-12">
                            <button class="btn btn-primary btn-submit" type="button" onclick="save_basic_info('{$basic_info['id']}')">保存</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab3_2">
                <form class="form-horizontal ng-scope ng-invalid ng-invalid-required ng-valid-pattern ng-valid-email ng-valid-date ng-pristine"  novalidate="" style="margin-top: 20px;">
                    <div class="row basic-form col-md-10 col-lg-offset-1" >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"> 起止时间</label>
                                <div class="col-sm-4 pull-left">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" id="start_time"  required="" style="" value="{$education['start_time']}">
                                </div>
                                <span class="link-word"> —— </span>
                                <div class="col-sm-4 pull-right">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" id="end_time" required="" style="" value="{$education['end_time']}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">学历阶段</label>
                                <div class="col-sm-9">
                                    <select id="level" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="$info.basic.marital_status" ng-options="options.name as options.name for options in $info.Marriage">
                                        {if {$education['level']} == ''}
                                            <option value="" class="" selected="selected">请选择</option>
                                        {else}
                                            <option value="" class="">请选择</option>
                                        {/if}
                                        {if {$education['level']} == '初中'}
                                            <option value="初中" class="" selected="selected">初中</option>
                                        {else}
                                            <option value="初中" class="">初中</option>
                                        {/if}
                                        {if {$education['level']} == '高中'}
                                            <option value="高中" class="" selected="selected">高中</option>
                                        {else}
                                            <option value="高中" class="">高中</option>
                                        {/if}
                                        {if {$education['level']} == '本科'}
                                            <option value="本科" class="" selected="selected">本科</option>
                                        {else}
                                            <option value="本科" class="">本科</option>
                                        {/if}
                                        {if {$education['level']} == '硕士'}
                                            <option value="硕士" class="" selected="selected">硕士</option>
                                        {else}
                                            <option value="硕士" class="">硕士</option>
                                        {/if}
                                        {if {$education['level']} == '博士'}
                                            <option value="博士" class="" selected="selected">博士</option>
                                        {else}
                                            <option value="博士" class="">博士</option>
                                        {/if}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">学校名称</label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" id="school_name" value="{$education['school_name']}"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">学校性质</label>
                                <div class="col-sm-9">
                                    <select id="school_type" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="$info.basic.marital_status" ng-options="options.name as options.name for options in $info.Marriage">
                                        {if {$education['type']} == ''}
                                            <option value="" class="" selected="selected">请选择</option>
                                        {else}
                                            <option value="" class="">请选择</option>
                                        {/if}
                                        {if {$education['type']} == '985'}
                                            <option value="985" class="" selected="selected">985</option>
                                        {else}
                                            <option value="985" class="">985</option>
                                        {/if}
                                        {if {$education['type']} == '211'}
                                            <option value="211" class="" selected="selected">211</option>
                                        {else}
                                            <option value="211" class="">211</option>
                                        {/if}
                                        {if {$education['type']} == '普通一本'}
                                            <option value="普通一本" class="" selected="selected">普通一本</option>
                                        {else}
                                            <option value="普通一本" class="">普通一本</option>
                                        {/if}
                                        {if {$education['type']} == '二本'}
                                            <option value="二本" class="" selected="selected">二本</option>
                                        {else}
                                            <option value="二本" class="">二本</option>
                                        {/if}
                                        {if {$education['type']} == '三本'}
                                            <option value="三本" class="" selected="selected">三本</option>
                                        {else}
                                            <option value="三本" class="">三本</option>
                                        {/if}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 联系电话</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid-pattern ng-not-empty ng-valid ng-valid-required" ng-pattern="/^(((1[345789][\d][0-9]{8}))(|\+\d))$/" id="contract_phone" value="{$education['phone']}" required="" style=""> <!-- ngIf: myFormBasic.mobile.$error.pattern && myFormBasic.$submitted==true --> <!-- ngIf: myFormBasic.mobile.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 就读专业</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" id="major" value="{$education['major']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"> 学校地址</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="school_address" name="school_address" value="{$education['address']}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 年级排名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" id="rank" placeholder="年级排名/年级总人数" value="{$education['rank']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">   学校网址 <br>
                                </label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="school_web" value="{$education['school_web']}" required=""> <!-- ngIf: myFormBasic.passport_number.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- ngIf: $info.immigration.length -->
                    <div class="row">
                        <div class="form-group text-center col-sm-12">
                            <button class="btn btn-primary btn-submit" type="button" onclick="save_education('{$education['id']}')">保存</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab3_3">
                <div class="col-sm-12">
                    <section class="panel">
                        <div class="panel-body">
                            <a type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#add_school_portal">新增选校</a>
                            <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                                <thead>
                                <tr role="row">
                                    <th>状态</th>
                                    <th>学校名称</th>
                                    <th>校区名称</th>
                                    <th>课程/专业名称</th>
                                    <th>申请截止日期</th>
                                    <th>入学时间</th>
                                    <th>学位名称</th>
                                    <th>是否honor</th>
                                    <th>是否带实习</th>
                                    <th>提交时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach $school_list as $one}
                                    <tr>
                                        <td>{$one['status']}</td>
                                        <td>{$one['school_name']}</td>
                                        <td>{$one['school_area']}</td>
                                        <td>{$one['profession_name']}</td>
                                        <td>{$one['end_time']}</td>
                                        <td>{$one['admission_time']}</td>
                                        <td>{$one['degree']}</td>
                                        <td>{$one['honors']}</td>
                                        <td>{$one['practice']}</td>
                                        <td>{$one['create_time']}</td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            <div class="tab-pane" id="tab3_4">
                <div class="col-sm-12">
                    <section class="panel">
                        <div class="panel-body">
                            <a type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#add_material_portal">新增材料</a>
                            <table cellspacing="0"  id="material_list" class="table table-bordered table-striped">
                                <thead>
                                <tr role="row">
                                    <th>材料名称</th>
                                    <th>类型</th>
                                    <th>学校</th>
                                    <th>材料下载</th>
                                    <th>上传时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach $material_list as $one}
                                    <tr>
                                        <td>{$one['name']}</td>
                                        <td>{$one['type']}</td>
                                        <td>{$one['school_name']}</td>
                                        <td>{$one['url']}</td>
                                        <td>{$one['create_time']}</td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            {*<div class="tab-pane" id="tab3_5"></div>*}
            {*<div class="tab-pane" id="tab3_6"></div>*}
        </div>
    </div>
</div>
<div class="modal fade " id="add_school_portal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <form class="form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-maxlength ng-valid-date ng-valid-url" style="padding-bottom:50px">
                <section class="section-form">
                    <header>
                        <h4> <span class="header-title-block"></span>选校信息 </h4> <hr>
                    </header>
                    <div class="row form-fields"> <!-- ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --><!-- ngIf: vm.model -->
                        <div class="col-md-6 ng-scope"  ng-if="vm.model" ng-repeat="col in vm.schoolInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field;bindModel=vm.model">
                            <label  class="col-md-3 control-label ng-binding required"> 学校名称 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name">
                                    <input id="add_school_name" type="text"  ng-model="locals.model"  typeahead-loading="loadingOptions" typeahead-no-results="noResults" typeahead-template-url="customTemplate.html" ng-required="required" class="form-control dynamic-search ng-pristine ng-empty ng-valid ng-valid-required ng-touched" aria-autocomplete="list" aria-expanded="false" aria-owns="typeahead-2019-5730" style="">
                                </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngIf: vm.model --><!-- end ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --><!-- ngIf: vm.model -->
                        <div class="col-md-6 ng-scope" ng-if="vm.model" ng-repeat="col in vm.schoolInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field;bindModel=vm.model">
                            <label  class="col-md-3 control-label ng-binding"> 校区名称 </label> <div class="col-md-8"> <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name">
                                    <input ng-switch-when="text" ng-model="model[options.field]" id="school_area" placeholder="请输入校区名称" class="form-control ng-pristine ng-untouched ng-scope ng-empty ng-valid ng-valid-required" type="text" ng-disabled="options.disabled" ng-required="options.required"><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: url --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker --> </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngIf: vm.model --><!-- end ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --><!-- ngIf: vm.model -->
                        <div class="col-md-6 ng-scope" ng-if="vm.model" ng-repeat="col in vm.schoolInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field;bindModel=vm.model">
                            <label  class="col-md-3 control-label ng-binding required"> 入学时间 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name"> <!-- ngSwitchWhen: text --> <!-- ngSwitchWhen: url --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select -->
                                    <div on="type" ng-switch="" class="ss-dmc-control ng-isolate-scope ng-not-empty ng-valid ng-valid-required" ng-switch-when="select" type="'select'" has-depend="options.hasDepend" depend-on="options.dependOn" options="options.options" params="options.params" code="options.code" ng-model="model[options.field]" id="school_type" value-field="options.valueField" ng-required="options.required" required="required"> <!-- ngSwitchWhen: select -->
                                        <select ng-switch-when="select" id="admission_time" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-empty">
                                            <option value="" class="" selected="selected">请选择</option>
                                            <option label="2016" value="2016">2016</option>
                                            <option label="2017" value="2017">2017</option>
                                            <option label="2018" value="2018">2018</option>
                                            <option label="2019" value="2019">2019</option>
                                            <option label="2020" value="2020">2020</option>
                                            <option label="2021" value="2021">2021</option>
                                        </select>
                                    </div>
                                </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngIf: vm.model --><!-- end ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --><!-- ngIf: vm.model -->
                        <div class="col-md-6 ng-scope m-b-0" ng-if="vm.model" ng-repeat="col in vm.schoolInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field;bindModel=vm.model"> <label  class="col-md-3 control-label ng-binding required"> 学位名称 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name"> <!-- ngSwitchWhen: text -->
                                    <input ng-switch-when="text" ng-model="model[options.field]" id="degree" placeholder="请输入学位名称" class="form-control ng-pristine ng-untouched ng-scope ng-empty ng-invalid ng-invalid-required" type="text" ng-disabled="options.disabled" ng-required="options.required" required="required"><!-- end ngSwitchWhen: -->
                                </div> <!-- ngIf: col.helper -->
                                <span ng-if="col.helper" class="help-block ng-binding ng-scope">本科B.S. or B.A. 研究生M.S. in Engineering or M.Eng</span><!-- end ngIf: col.helper -->
                            </div>
                        </div><!-- end ngIf: vm.model --><!-- end ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --> <!-- ngRepeat: apply_major in vm.model.apply_majors track by $index -->
                        <!-- end ngRepeat: apply_major in vm.model.apply_majors track by $index -->
                    </div>
                </section>
                <section class="section-form">
                    <header> <h4> <span class="header-title-block"></span>课程/专业信息 </h4> <hr>
                    </header> <!-- ngRepeat: apply_major in vm.model.apply_majors track by $index -->
                    <div ng-repeat="apply_major in vm.model.apply_majors track by $index" class="row form-fields ng-scope"> <!-- ngIf: $index!==0 -->
                        <div class="col-md-6" >
                            <label class="required col-md-3 control-label">专业分类</label>
                            <div class="col-md-4">
                                <div on="type" ng-switch="" class="ss-dmc-control ng-pristine ng-untouched ng-isolate-scope ng-empty ng-invalid ng-invalid-required" type="'select'" ng-model="apply_major.major_type" code="'primary_major'"  required="required" id="major_type0"> <!-- ngSwitchWhen: select -->
                                    <select id="class" ng-switch-when="select" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-empty"><option value="" class="" selected="selected">请选择</option><option label="文科" value="string:文科">文科</option><option label="理科" value="string:理科">理科</option><option label="工科" value="string:工科">工科</option><option label="商科" value="string:商科">商科</option><option label="医学" value="string:医学">医学</option><option label="建筑类" value="string:建筑类">建筑类</option><option label="艺术类" value="string:艺术类">艺术类</option><option label="其他" value="string:其他">其他</option>
                                    </select><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label class="col-md-3 control-label" ng-class="{ 'required ': vm.selectionCountry !== '英国' }"> 申请截止日期 </label>
                                <!-- ngIf: vm.selectionCountry === '美国' -->
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="apply_end_time" name="apply_end_time" style="width:300px;">
                                    <div uib-datepicker-popup-wrap="" ng-model="date" ng-change="dateSelection(date)" template-url="uib/template/datepickerPopup/popup.html" class="ng-pristine ng-untouched ng-valid ng-scope ng-empty"><!-- ngIf: isOpen -->
                                    </div>
                                </div>
                            </div> <!-- ngIf: vm.selectionCountry === '美国' && apply_major.apply_batch && apply_major.apply_end_time --> <!-- ngIf: vm.selectionCountry === '美国' && apply_major.apply_batch && apply_major.apply_end_time && apply_major.apply_batch_2 && apply_major.apply_end_time_2 -->
                        </div> <!-- ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) -->
                        <div class="col-md-6 ng-scope m-b-0" ng-repeat="col in vm.majorInfoFields | filter: vm.hasField(vm.country)" >
                            <label  class="col-md-3 control-label ng-binding required"> 课程/专业名称 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name"> <!-- ngSwitchWhen: text -->
                                    <input ng-switch-when="text" ng-model="model[options.field]" id="profession_name" placeholder="请输入课程/专业名称" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-not-empty ng-valid-required" type="text" ng-disabled="options.disabled" ng-required="options.required" required="required"><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: url --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker -->
                                </div> <!-- ngIf: col.helper -->
                                <span ng-if="col.helper" class="help-block ng-binding ng-scope">请使用申请国家的官方语言（英文或其他）填写</span><!-- end ngIf: col.helper -->
                            </div>
                        </div><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) -->
                        <div class="col-md-6 ng-scope m-b-0"  ng-repeat="col in vm.majorInfoFields | filter: vm.hasField(vm.country)" >
                            <label  class="col-md-3 control-label ng-binding"> 申请截止日期链接 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name"> <!-- ngSwitchWhen: text --> <!-- ngSwitchWhen: url -->
                                    <input ng-switch-when="url" ng-model="model[options.field]" id="end_time_link" placeholder="请输入申请截止日期链接" class="form-control ng-pristine ng-untouched ng-scope ng-empty ng-valid ng-valid-required ng-valid-url" type="url" ng-required="options.required"><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker -->
                                </div> <!-- ngIf: col.helper -->
                                <span ng-if="col.helper" class="help-block ng-binding ng-scope">链接地址必须以http://开头</span>
                                <!-- end ngIf: col.helper -->
                            </div>
                        </div><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) -->
                        <div class="col-md-6 ng-scope"  ng-repeat="col in vm.majorInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field + $parent.$parent.$index;bindModel=apply_major">
                            <label  class="col-md-3 control-label ng-binding"> 是否带实习 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions" on-reload="col.onReload()" id="name">
                                    <div on="type" ng-switch="" class="ss-dmc-control ng-isolate-scope ng-empty ng-valid ng-valid-required" ng-switch-when="select" type="'select'" has-depend="options.hasDepend" depend-on="options.dependOn" options="options.options" params="options.params" code="options.code"  ng-model="model[options.field]" id="is_coop0" value-field="options.valueField" ng-required="options.required"> <!-- ngSwitchWhen: select -->
                                        <select id="practice" ng-switch-when="select" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-empty">
                                            <option value="" class="" selected="selected">请选择</option>
                                            <option label="是" value="1">是</option>
                                            <option label="否" value="2">否</option>
                                        </select><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi -->
                                    </div><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker -->
                                </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) -->
                        <div class="col-md-6 ng-scope m-b-0" ng-repeat="col in vm.majorInfoFields | filter: vm.hasField(vm.country)" >
                            <label class="col-md-3 control-label ng-binding required"> 课程/专业链接 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions" on-reload="col.onReload()" id="name"> <!-- ngSwitchWhen: text --> <!-- ngSwitchWhen: url -->
                                    <input ng-switch-when="url" ng-model="model[options.field]" id="link" placeholder="请输入课程/专业链接" class="form-control ng-pristine ng-untouched ng-scope ng-empty ng-invalid ng-invalid-required ng-valid-url" type="url" ng-required="options.required" required="required"><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker -->
                                </div> <!-- ngIf: col.helper -->
                                <span ng-if="col.helper" class="help-block ng-binding ng-scope">链接地址必须以http://开头</span><!-- end ngIf: col.helper -->
                            </div>
                        </div><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) -->
                        <div class="col-md-6 ng-scope" ng-repeat="col in vm.majorInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field + $parent.$parent.$index;bindModel=apply_major">
                            <label class="col-md-3 control-label ng-binding"> 是否honors </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name"> <!-- ngSwitchWhen: text --> <!-- ngSwitchWhen: url --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select -->
                                    <div on="type" ng-switch="" class="ss-dmc-control ng-isolate-scope ng-empty ng-valid ng-valid-required" ng-switch-when="select" type="'select'" has-depend="options.hasDepend" depend-on="options.dependOn" options="options.options" params="options.params" code="options.code"  ng-model="model[options.field]" id="is_honous0" value-field="options.valueField" ng-required="options.required"> <!-- ngSwitchWhen: select -->
                                        <select id="honors" ng-switch-when="select" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-empty">
                                            <option value="" class="" selected="selected">请选择</option>
                                            <option label="是" value="1">是</option>
                                            <option label="否" value="2">否</option>
                                        </select><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi -->
                                    </div><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker -->
                                </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) --><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) -->
                        <div class="col-md-6" > <label class="col-md-3 control-label">备注</label> <div class="col-md-8"> <textarea ng-model="apply_major.remark" id="remark_0" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength" rows="4" ng-maxlength="400" placeholder="该选校的特别注意事项等备注，会在定校书中体现"></textarea> <span class="help-block">最多输入400个字</span>
                            </div>
                        </div> <!-- ngIf: $index!==0 -->
                    </div><!-- end ngRepeat: apply_major in vm.model.apply_majors track by $index --> <!-- ngIf: !vm.isEditMode -->
                    {*<div ng-if="!vm.isEditMode" class="ng-scope">*}
                        {*<a ng-click="vm.addMajorSection()" class="col-md-offset-1 btn btn-primary" href="">添加课程专业</a>*}
                    {*</div><!-- end ngIf: !vm.isEditMode -->*}
                </section>
                <hr>
                <div class="col-md-12 text-center buttons">
                    <a type="button" class="btn btn-primary" onclick="add_school()">新增</a>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" id="add_material_portal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    新增材料
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" hidden="hidden" id="customer_id" value="{$customer_info['id']}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">材料名称：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="material_name">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">材料类型：</label>
                        <select id="material_type" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">签证递交回执</option>
                            <option value="2">获签信</option>
                            <option value="3">拒签信</option>
                            <option value="4">学校申请回执</option>
                            <option value="5">offer</option>
                            <option value="6">拒录信</option>
                            <option value="7">其他</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">学校：</label>
                        <select id="school_id" class="col-sm-6">
                            <option value=""></option>
                            {foreach $school_list as $one}
                            <option value="{$one['id']}">{$one['school_name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">上传材料：</label>
                        <input type="file" name="file" id="file" />
                        <br/>
                    </div>
                    <input type="button" class="btn btn-primary" id="upload" value="新增" />
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
    $('#member_list').DataTable({
        "displayLength": 25,
        "order": [],
        "language": {
            "search":"搜索",
            "lengthMenu": "每页 _MENU_ 条记录",
            "zeroRecords": "没有找到记录",
            "infoEmpty": "无记录",
            "infoFiltered": "(从 _MAX_ 条记录过滤)"
        }
    });

    $('#material_list').DataTable({
        "displayLength": 25,
        "order": [],
        "language": {
            "search":"搜索",
            "lengthMenu": "每页 _MENU_ 条记录",
            "zeroRecords": "没有找到记录",
            "infoEmpty": "无记录",
            "infoFiltered": "(从 _MAX_ 条记录过滤)"
        }
    });

    //保存客户基本信息
    function save_basic_info(id) {
        var name_pinyin = $("#name_pinyin").val();
        var english_name = $("#english_name").val();
        var used_name = $("#used_name").val();
        var id_number = $("#id_number").val();
        var email = $("#email").val();
        var landline_number = $("#landline_number").val();
        var address = $("#address").val();
        var zip_code = $("#zip_code").val();
        var mail_address = $("#mail_address").val();
        var mail_zip_code = $("#mail_zip_code").val();
        var place_birth = $("#place_birth").val();
        var birthday = $("#birthday").val();
        var gender = $("#gender").val();
        var native_language = $("#native_language").val();
        var second_language = $("#second_language").val();
        var country = $("#country").val();
        var marital_status = $("#marital_status").val();
        var passport = $("#passport").val();
        var passport_place = $("#passport_place").val();
        var passport_date = $("#passport_date").val();
        var request = {
            "id": id,
            "name_pinyin": name_pinyin,
            "english_name": english_name,
            "used_name": used_name,
            "id_number": id_number,
            "email": email,
            "landline_number": landline_number,
            "address": address,
            "zip_code": zip_code,
            "mail_address": mail_address,
            "mail_zip_code": mail_zip_code,
            "place_birth": place_birth,
            "birthday": birthday,
            "gender": gender,
            "native_language": native_language,
            "second_language": second_language,
            "country": country,
            "marital_status": marital_status,
            "passport": passport,
            "passport_place": passport_place,
            "passport_date": passport_date
        };
        var uri = "http://"+window.location.host+"/api/customer/savebasicinfo";
        $.ajax({
            url: uri,
            type: "POST",
            data: request,
            dataType:"json",
            async :false,
            success: function (result) {
                if (result.error.returnCode == 0) {
                    alert('保存成功');
                }else {
                    alert(result.error.returnUserMessage);
                }
            },
            error:function(result) {
                alert("系统异常");
            }
        });
    }

    //保存客户教育信息
    function save_education(id) {
        var start_time = $("#start_time").val();
        var end_time = $("#end_time").val();
        var major = $("#major").val();
        var level = $("#level").val();
        var type = $("#school_type").val();
        var phone = $("#contract_phone").val();
        var address = $("#school_address").val();
        var rank = $("#rank").val();
        var school_web = $("#school_web").val();
        var school_name = $("#school_name").val();
        var request = {
            "id": id,
            "start_time": start_time,
            "end_time": end_time,
            "major": major,
            "level": level,
            "type": type,
            "phone": phone,
            "school_name": school_name,
            "address": address,
            "school_web": school_web,
            "rank": rank,
        };
        var uri = "http://"+window.location.host+"/api/customer/saveeducation";
        $.ajax({
            url: uri,
            type: "POST",
            data: request,
            dataType:"json",
            async :false,
            success: function (result) {
                if (result.error.returnCode == 0) {
                    alert('保存成功');
                }else {
                    alert(result.error.returnUserMessage);
                }
            },
            error:function(result) {
                alert("系统异常");
            }
        });
    }
    
    function add_school() {
        var customer_id = {$customer_info['id']};
        var school_name = $("#add_school_name").val();
        var school_area = $("#school_area").val();
        var degree = $("#degree").val();
        var admission_time = $("#admission_time").val();
        var c_class = $("#class").val();
        var profession_name = $("#profession_name").val();
        var link = $("#link").val();
        var end_time = $("#apply_end_time").val();
        var end_time_link = $("#end_time_link").val();
        var practice = $("#practice").val();
        var honors = $("#honors").val();
        var remark = $("#remark").val();
        var request = {
            "customer_id": customer_id,
            "school_name": school_name,
            "school_area": school_area,
            "degree": degree,
            "admission_time": admission_time,
            "class": c_class,
            "profession_name": profession_name,
            "link": link,
            "end_time": end_time,
            "end_time_link": end_time_link,
            "practice": practice,
            "honors": honors,
            "remark": remark
        };
        var uri = "http://"+window.location.host+"/api/school/add";
        $.ajax({
            url: uri,
            type: "POST",
            data: request,
            dataType:"json",
            async :false,
            success: function (result) {
                if (result.error.returnCode == 0) {
                    alert('添加成功');
                    window.location.reload();
                }else {
                    alert(result.error.returnUserMessage);
                }
            },
            error:function(result) {
                alert("系统异常");
            }
        });
    }

    $(function () {
        $("#upload").click(function () {
            var formData = new FormData();
            customer_id = $("#customer_id").val();
            material_name = $("#material_name").val();
            type = $("#material_type").val();
            school_id = $("#school_id").val();
            formData.append("customer_id", customer_id);
            formData.append("name", material_name);
            formData.append("type", type);
            formData.append("school_id", school_id);
            formData.append("file", document.getElementById("file").files[0]);
            $.ajax({
                url: "/api/customer/addmaterial",
                type: "POST",
                data: formData,
                /**
                 *必须false才会自动加上正确的Content-Type
                 */
                contentType: false,
                /**
                 * 必须false才会避开jQuery对 formdata 的默认处理
                 * XMLHttpRequest会对 formdata 进行正确的处理
                 */
                processData: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert("新增成功！");
                        window.location.reload();
                    }else {
                        alert('新增失败！');
                    }
                },
                error: function () {
                    alert("新增异常！");
                }
            });
        });
    });
</script>

{include "layout/footer.tpl"}

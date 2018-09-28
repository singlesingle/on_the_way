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

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success bootstrap-admin-alert">
                <h4>客户详细信息</h4>
            </div>
        </div>
    </div>
    <div class="tab-box" id="myTab3">
        <ul class="nav nav-tabs king-nav-tabs2  king-tab-success">
            <li class="active">
                <a href="#tab3_1" data-toggle="tab">摘要</a>
            </li>
            <li>
                <a href="#tab3_2" data-toggle="tab">学生信息</a>
            </li>
            <li>
                <a href="#tab3_3" data-toggle="tab">选校</a>
            </li>
            <li>
                <a href="#tab3_4" data-toggle="tab">留学材料</a>
            </li>
            <li>
                <a href="#tab3_5" data-toggle="tab">申请进度</a>
            </li>
            <li>
                <a href="#tab3_6" data-toggle="tab">签证进度</a>
            </li>
        </ul>
        <div class="tab-content mb20">
            <div class="tab-pane" id="tab3_1">

            </div>
            <div class="tab-pane" id="tab3_2">
                <form name="myFormBasic" class="form-horizontal ng-scope ng-invalid ng-invalid-required ng-valid-pattern ng-valid-email ng-valid-date ng-pristine"  novalidate="" style="margin-top: 20px;">
                    <div class="row basic-form col-md-10 col-lg-offset-1" >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"><sup class="text-danger">*</sup>中文名</label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control ng-pristine ng-untouched ng-not-empty ng-valid ng-valid-required" id="name" placeholder="请与护照一致" required="" style="" value="{$customer_info['name']}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"><sup class="text-danger">*</sup>中文名拼音</label>
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
                                <label class="col-sm-3 control-label"><sup class="text-danger">*</sup>身份证号码</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid-pattern ng-not-empty ng-valid ng-valid-required" ng-pattern="/(^\d{15}$)|(^\d{17}(\d|X)$)/" ng-change="$info.changeIdentityNum($info.basic.identity_number)" id="id_number" value="{$basic_info['id_number']}" required="" style=""> <!-- ngIf: myFormBasic.identity_number.$error.pattern && myFormBasic.$submitted==true --> <!-- ngIf: myFormBasic.identity_number.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><sup class="text-danger">*</sup>手机号码</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid-pattern ng-not-empty ng-valid ng-valid-required" ng-pattern="/^(((1[345789][\d][0-9]{8}))(|\+\d))$/" id="phone" value="{$customer_info['phone']}" required="" style=""> <!-- ngIf: myFormBasic.mobile.$error.pattern && myFormBasic.$submitted==true --> <!-- ngIf: myFormBasic.mobile.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group"> <label class="col-sm-3 control-label"><sup class="text-danger">*</sup>电子邮箱</label>
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
                                <label class="col-sm-3 control-label"><sup class="text-danger">*</sup>出生地</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-pattern" id="place_birth" value="{$basic_info['place_birth']}"> <!-- ngIf: myFormBasic.phone.$error.pattern && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label pt0"><sup class="text-danger">*</sup>出生日期</label>
                                <div class="col-sm-9">
                                    <div class="date-time">
                                        <button type="button" class="btn btn-default dropdown-toggle btn-date-picker col-sm-12 ng-pristine ng-untouched ng-binding ng-isolate-scope ng-valid-date ng-not-empty ng-valid ng-valid-required"   id="birthday" value="{$basic_info['birthday']}" required="" style=""> 1986-10-08 </button><div uib-datepicker-popup-wrap="" ng-model="date" ng-change="dateSelection(date)" template-url="uib/template/datepickerPopup/popup.html" class="ng-pristine ng-untouched ng-valid ng-scope ng-not-empty" style=""><!-- ngIf: isOpen -->
                                        </div>
                                    </div> <!-- ngIf: myFormBasic.birthday.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><sup class="text-danger">*</sup>性别</label>
                                <div class="col-sm-9">
                                    <select id="gender" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-options="Gender.name as Gender.name for Gender in $info.Gender" required=""><option value="" class="" selected="selected">请选择</option>
                                        <option label="男" value="1">男</option>
                                        <option label="女" value="2">女</option>
                                    </select> <!-- ngIf: myFormBasic.sex.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><sup class="text-danger">*</sup>母语</label>
                                <div class="col-sm-9">
                                    <select id="native_language" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-model="$info.basic.native_language" ng-options="options.name as options.name for options in $info.Languages" required=""><option value="" class="" selected="selected">请选择</option><option label="汉语" value="string:汉语">汉语</option><option label="英语" value="string:英语">英语</option><option label="法语" value="string:法语">法语</option><option label="俄语" value="string:俄语">俄语</option><option label="西班牙语" value="string:西班牙语">西班牙语</option><option label="德语" value="string:德语">德语</option><option label="阿拉伯语" value="string:阿拉伯语">阿拉伯语</option><option label="日语" value="string:日语">日语</option><option label="韩语" value="string:韩语">韩语</option><option label="葡萄牙语" value="string:葡萄牙语">葡萄牙语</option><option label="印地语" value="string:印地语">印地语</option>
                                    </select> <!-- ngIf: myFormBasic.native_language.$error.required && myFormBasic.$submitted==true -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">第二语言</label> <div class="col-sm-9">
                                    <select id="second_language" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="$info.basic.second_language" ng-options="options.name as options.name for options in $info.Languages"><option value="" class="" selected="selected">请选择</option><option label="汉语" value="string:汉语">汉语</option><option label="英语" value="string:英语">英语</option><option label="法语" value="string:法语">法语</option><option label="俄语" value="string:俄语">俄语</option><option label="西班牙语" value="string:西班牙语">西班牙语</option><option label="德语" value="string:德语">德语</option><option label="阿拉伯语" value="string:阿拉伯语">阿拉伯语</option><option label="日语" value="string:日语">日语</option><option label="韩语" value="string:韩语">韩语</option><option label="葡萄牙语" value="string:葡萄牙语">葡萄牙语</option>
                                        <option label="印地语" value="string:印地语">印地语</option></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><sup class="text-danger">*</sup>国籍</label>
                                <div class="col-sm-9"> <div>
                                        <div on="type" ng-switch="" class="ss-dmc-control ng-pristine ng-untouched ng-isolate-scope ng-not-empty ng-valid ng-valid-required" type="'select'" code="'region_load_countries'" ng-model="$info.basic.nationality" id="country" required="required" style=""> <!-- ngSwitchWhen: select --><select ng-switch-when="select" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-not-empty" style=""><option value="" class="" selected="selected">请选择</option><option label="中国" value="string:中国" selected="selected">中国</option><option label="中国香港" value="string:中国香港">中国香港</option><option label="中国澳门" value="string:中国澳门">中国澳门</option>
                                                <option label="英国" value="string:英国">英国</option><option label="美国" value="string:美国">美国</option><option label="加拿大" value="string:加拿大">加拿大</option><option label="澳大利亚" value="string:澳大利亚">澳大利亚</option><option label="意大利" value="string:意大利">意大利</option><option label="韩国" value="string:韩国">韩国</option><option label="法国" value="string:法国">法国</option><option label="日本" value="string:日本">日本</option><option label="德国" value="string:德国">德国</option><option label="阿富汗" value="string:阿富汗">阿富汗</option><option label="俄罗斯" value="string:俄罗斯">俄罗斯</option><option label="奥兰" value="string:奥兰">奥兰</option><option label="阿尔巴尼亚" value="string:阿尔巴尼亚">阿尔巴尼亚</option><option label="阿尔及利亚" value="string:阿尔及利亚">阿尔及利亚</option><option label="美属萨摩亚" value="string:美属萨摩亚">美属萨摩亚</option><option label="安道尔" value="string:安道尔">安道尔</option><option label="安哥拉" value="string:安哥拉">安哥拉</option><option label="安圭拉" value="string:安圭拉">安圭拉</option><option label="安提瓜和巴布达" value="string:安提瓜和巴布达">安提瓜和巴布达</option><option label="阿根廷" value="string:阿根廷">阿根廷</option><option label="亚美尼亚" value="string:亚美尼亚">亚美尼亚</option><option label="阿鲁巴" value="string:阿鲁巴">阿鲁巴</option><option label="奥地利" value="string:奥地利">奥地利</option>
                                                <option label="阿塞拜疆" value="string:阿塞拜疆">阿塞拜疆</option><option label="巴哈马" value="string:巴哈马">巴哈马</option><option label="巴林" value="string:巴林">巴林</option><option label="孟加拉国" value="string:孟加拉国">孟加拉国</option><option label="巴巴多斯" value="string:巴巴多斯">巴巴多斯</option><option label="白俄罗斯" value="string:白俄罗斯">白俄罗斯</option><option label="比利时" value="string:比利时">比利时</option><option label="伯利兹" value="string:伯利兹">伯利兹</option><option label="贝宁" value="string:贝宁">贝宁</option><option label="百慕大" value="string:百慕大">百慕大</option><option label="不丹" value="string:不丹">不丹</option><option label="玻利维亚" value="string:玻利维亚">玻利维亚</option><option label="波斯尼亚和黑塞哥维那" value="string:波斯尼亚和黑塞哥维那">波斯尼亚和黑塞哥维那</option><option label="博茨瓦纳" value="string:博茨瓦纳">博茨瓦纳</option><option label="布韦岛" value="string:布韦岛">布韦岛</option><option label="巴西" value="string:巴西">巴西</option><option label="文莱" value="string:文莱">文莱</option><option label="保加利亚" value="string:保加利亚">保加利亚</option><option label="布基纳法索" value="string:布基纳法索">布基纳法索</option><option label="布隆迪" value="string:布隆迪">布隆迪</option><option label="柬埔寨" value="string:柬埔寨">柬埔寨</option><option label="喀麦隆" value="string:喀麦隆">喀麦隆</option><option label="佛得角" value="string:佛得角">佛得角</option><option label="中非共和国" value="string:中非共和国">中非共和国</option><option label="乍得" value="string:乍得">乍得</option><option label="智利" value="string:智利">智利</option><option label="圣诞岛" value="string:圣诞岛">圣诞岛</option><option label="科科斯（基林）群岛" value="string:科科斯（基林）群岛">科科斯（基林）群岛</option><option label="哥伦比亚" value="string:哥伦比亚">哥伦比亚</option><option label="科摩罗" value="string:科摩罗">科摩罗</option><option label="刚果（布）" value="string:刚果（布）">刚果（布）</option><option label="刚果（金）" value="string:刚果（金）">刚果（金）</option><option label="库克群岛" value="string:库克群岛">库克群岛</option><option label="哥斯达黎加" value="string:哥斯达黎加">哥斯达黎加</option><option label="科特迪瓦" value="string:科特迪瓦">科特迪瓦</option><option label="克罗地亚" value="string:克罗地亚">克罗地亚</option><option label="古巴" value="string:古巴">古巴</option><option label="塞浦路斯" value="string:塞浦路斯">塞浦路斯</option><option label="捷克" value="string:捷克">捷克</option><option label="丹麦" value="string:丹麦">丹麦</option>
                                                <option label="吉布提" value="string:吉布提">吉布提</option><option label="多米尼克" value="string:多米尼克">多米尼克</option><option label="东帝汶" value="string:东帝汶">东帝汶</option><option label="厄瓜多尔" value="string:厄瓜多尔">厄瓜多尔</option><option label="埃及" value="string:埃及">埃及</option><option label="萨尔瓦多" value="string:萨尔瓦多">萨尔瓦多</option><option label="赤道几内亚" value="string:赤道几内亚">赤道几内亚</option><option label="厄立特里亚" value="string:厄立特里亚">厄立特里亚</option><option label="爱沙尼亚" value="string:爱沙尼亚">爱沙尼亚</option><option label="埃塞俄比亚" value="string:埃塞俄比亚">埃塞俄比亚</option><option label="法罗群岛" value="string:法罗群岛">法罗群岛</option><option label="斐济" value="string:斐济">斐济</option><option label="芬兰" value="string:芬兰">芬兰</option><option label="法属圭亚那" value="string:法属圭亚那">法属圭亚那</option><option label="法属波利尼西亚" value="string:法属波利尼西亚">法属波利尼西亚</option><option label="加蓬" value="string:加蓬">加蓬</option><option label="冈比亚" value="string:冈比亚">冈比亚</option><option label="格鲁吉亚" value="string:格鲁吉亚">格鲁吉亚</option><option label="加纳" value="string:加纳">加纳</option><option label="直布罗陀" value="string:直布罗陀">直布罗陀</option><option label="希腊" value="string:希腊">希腊</option><option label="格林纳达" value="string:格林纳达">格林纳达</option><option label="瓜德罗普" value="string:瓜德罗普">瓜德罗普</option><option label="关岛" value="string:关岛">关岛</option><option label="危地马拉" value="string:危地马拉">危地马拉</option><option label="根西" value="string:根西">根西</option><option label="几内亚" value="string:几内亚">几内亚</option><option label="几内亚比绍" value="string:几内亚比绍">几内亚比绍</option><option label="圭亚那" value="string:圭亚那">圭亚那</option><option label="海地" value="string:海地">海地</option><option label="洪都拉斯" value="string:洪都拉斯">洪都拉斯</option><option label="匈牙利" value="string:匈牙利">匈牙利</option><option label="冰岛" value="string:冰岛">冰岛</option><option label="印度" value="string:印度">印度</option><option label="印尼" value="string:印尼">印尼</option><option label="伊朗" value="string:伊朗">伊朗</option><option label="伊拉克" value="string:伊拉克">伊拉克</option>
                                                <option label="爱尔兰" value="string:爱尔兰">爱尔兰</option><option label="马恩岛" value="string:马恩岛">马恩岛</option><option label="以色列" value="string:以色列">以色列</option><option label="牙买加" value="string:牙买加">牙买加</option><option label="约旦" value="string:约旦">约旦</option><option label="哈萨克斯坦" value="string:哈萨克斯坦">哈萨克斯坦</option><option label="肯尼亚" value="string:肯尼亚">肯尼亚</option><option label="基里巴斯" value="string:基里巴斯">基里巴斯</option><option label="朝鲜" value="string:朝鲜">朝鲜</option><option label="科威特" value="string:科威特">科威特</option><option label="吉尔吉斯斯坦" value="string:吉尔吉斯斯坦">吉尔吉斯斯坦</option><option label="老挝" value="string:老挝">老挝</option><option label="拉脱维亚" value="string:拉脱维亚">拉脱维亚</option><option label="黎巴嫩" value="string:黎巴嫩">黎巴嫩</option><option label="莱索托" value="string:莱索托">莱索托</option><option label="利比里亚" value="string:利比里亚">利比里亚</option><option label="利比亚" value="string:利比亚">利比亚</option><option label="列支敦士登" value="string:列支敦士登">列支敦士登</option><option label="立陶宛" value="string:立陶宛">立陶宛</option><option label="卢森堡" value="string:卢森堡">卢森堡</option><option label="马其顿" value="string:马其顿">马其顿</option><option label="马达加斯加" value="string:马达加斯加">马达加斯加</option><option label="马拉维" value="string:马拉维">马拉维</option><option label="马来西亚" value="string:马来西亚">马来西亚</option><option label="马尔代夫" value="string:马尔代夫">马尔代夫</option><option label="马耳他" value="string:马耳他">马耳他</option><option label="马绍尔群岛" value="string:马绍尔群岛">马绍尔群岛</option><option label="马提尼克" value="string:马提尼克">马提尼克</option><option label="毛里塔尼亚" value="string:毛里塔尼亚">毛里塔尼亚</option><option label="毛里求斯" value="string:毛里求斯">毛里求斯</option><option label="马约特" value="string:马约特">马约特</option><option label="墨西哥" value="string:墨西哥">墨西哥</option><option label="圣马丁行政区" value="string:圣马丁行政区">圣马丁行政区</option><option label="摩尔多瓦" value="string:摩尔多瓦">摩尔多瓦</option><option label="摩纳哥" value="string:摩纳哥">摩纳哥</option><option label="蒙古" value="string:蒙古">蒙古</option><option label="黑山" value="string:黑山">黑山</option><option label="蒙特塞拉特" value="string:蒙特塞拉特">蒙特塞拉特</option><option label="摩洛哥" value="string:摩洛哥">摩洛哥</option><option label="莫桑比克" value="string:莫桑比克">莫桑比克</option><option label="缅甸" value="string:缅甸">缅甸</option><option label="纳米比亚" value="string:纳米比亚">纳米比亚</option><option label="瑙鲁" value="string:瑙鲁">瑙鲁</option><option label="尼泊尔" value="string:尼泊尔">尼泊尔</option><option label="荷兰" value="string:荷兰">荷兰</option><option label="新喀里多尼亚" value="string:新喀里多尼亚">新喀里多尼亚</option><option label="新西兰" value="string:新西兰">新西兰</option><option label="尼加拉瓜" value="string:尼加拉瓜">尼加拉瓜</option><option label="尼日尔" value="string:尼日尔">尼日尔</option><option label="尼日利亚" value="string:尼日利亚">尼日利亚</option><option label="纽埃" value="string:纽埃">纽埃</option><option label="诺福克岛" value="string:诺福克岛">诺福克岛</option><option label="挪威" value="string:挪威">挪威</option><option label="阿曼" value="string:阿曼">阿曼</option><option label="巴基斯坦" value="string:巴基斯坦">巴基斯坦</option><option label="帕劳" value="string:帕劳">帕劳</option><option label="巴勒斯坦" value="string:巴勒斯坦">巴勒斯坦</option><option label="巴拿马" value="string:巴拿马">巴拿马</option><option label="巴布亚新几内亚" value="string:巴布亚新几内亚">巴布亚新几内亚</option><option label="巴拉圭" value="string:巴拉圭">巴拉圭</option><option label="秘鲁" value="string:秘鲁">秘鲁</option><option label="菲律宾" value="string:菲律宾">菲律宾</option><option label="皮特凯恩群岛" value="string:皮特凯恩群岛">皮特凯恩群岛</option><option label="波兰" value="string:波兰">波兰</option><option label="葡萄牙" value="string:葡萄牙">葡萄牙</option><option label="波多黎各" value="string:波多黎各">波多黎各</option><option label="卡塔尔" value="string:卡塔尔">卡塔尔</option><option label="留尼汪" value="string:留尼汪">留尼汪</option><option label="罗马尼亚" value="string:罗马尼亚">罗马尼亚</option><option label="卢旺达" value="string:卢旺达">卢旺达</option><option label="圣赫勒拿" value="string:圣赫勒拿">圣赫勒拿</option><option label="圣基茨和尼维斯" value="string:圣基茨和尼维斯">圣基茨和尼维斯</option><option label="圣卢西亚" value="string:圣卢西亚">圣卢西亚</option><option label="英属维尔京群岛" value="string:英属维尔京群岛">英属维尔京群岛</option><option label="萨摩亚" value="string:萨摩亚">萨摩亚</option><option label="圣马力诺" value="string:圣马力诺">圣马力诺</option><option label="圣多美和普林西比" value="string:圣多美和普林西比">圣多美和普林西比</option><option label="沙特阿拉伯" value="string:沙特阿拉伯">沙特阿拉伯</option><option label="塞内加尔" value="string:塞内加尔">塞内加尔</option><option label="塞尔维亚" value="string:塞尔维亚">塞尔维亚</option><option label="塞舌尔" value="string:塞舌尔">塞舌尔</option><option label="塞拉利昂" value="string:塞拉利昂">塞拉利昂</option><option label="新加坡" value="string:新加坡">新加坡</option><option label="斯洛伐克" value="string:斯洛伐克">斯洛伐克</option><option label="斯洛文尼亚" value="string:斯洛文尼亚">斯洛文尼亚</option><option label="所罗门群岛" value="string:所罗门群岛">所罗门群岛</option><option label="索马里" value="string:索马里">索马里</option><option label="南非" value="string:南非">南非</option><option label="西班牙" value="string:西班牙">西班牙</option><option label="斯里兰卡" value="string:斯里兰卡">斯里兰卡</option>
                                                <option label="苏丹" value="string:苏丹">苏丹</option><option label="苏里南" value="string:苏里南">苏里南</option><option label="斯威士兰" value="string:斯威士兰">斯威士兰</option><option label="瑞典" value="string:瑞典">瑞典</option><option label="瑞士" value="string:瑞士">瑞士</option><option label="叙利亚" value="string:叙利亚">叙利亚</option><option label="中国台湾" value="string:中国台湾">中国台湾</option><option label="塔吉克斯坦" value="string:塔吉克斯坦">塔吉克斯坦</option><option label="坦桑尼亚" value="string:坦桑尼亚">坦桑尼亚</option><option label="泰国" value="string:泰国">泰国</option><option label="东帝汶" value="string:东帝汶">东帝汶</option><option label="多哥" value="string:多哥">多哥</option><option label="托克劳" value="string:托克劳">托克劳</option><option label="汤加" value="string:汤加">汤加</option><option label="特立尼达和多巴哥" value="string:特立尼达和多巴哥">特立尼达和多巴哥</option><option label="突尼斯" value="string:突尼斯">突尼斯</option><option label="土耳其" value="string:土耳其">土耳其</option><option label="土库曼斯坦" value="string:土库曼斯坦">土库曼斯坦</option><option label="图瓦卢" value="string:图瓦卢">图瓦卢</option><option label="乌干达" value="string:乌干达">乌干达</option><option label="乌克兰" value="string:乌克兰">乌克兰</option><option label="阿联酋" value="string:阿联酋">阿联酋</option><option label="乌拉圭" value="string:乌拉圭">乌拉圭</option><option label="乌兹别克斯坦" value="string:乌兹别克斯坦">乌兹别克斯坦</option><option label="越南" value="string:越南">越南</option><option label="梵蒂冈" value="string:梵蒂冈">梵蒂冈</option><option label="委内瑞拉" value="string:委内瑞拉">委内瑞拉</option><option label="越南" value="string:越南">越南</option><option label="瓦利斯和富图纳" value="string:瓦利斯和富图纳">瓦利斯和富图纳</option><option label="阿拉伯撒哈拉民主共和国" value="string:阿拉伯撒哈拉民主共和国">阿拉伯撒哈拉民主共和国</option><option label="也门" value="string:也门">也门</option><option label="赞比亚" value="string:赞比亚">赞比亚</option><option label="津巴布韦" value="string:津巴布韦">津巴布韦</option></select><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi --> </div> <!-- ngIf: myFormBasic.nationality.$error.required && myFormBasic.$submitted==true --> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">婚姻状况</label>
                                <div class="col-sm-9">
                                    <select id="marital_status" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="$info.basic.marital_status" ng-options="options.name as options.name for options in $info.Marriage"><option value="" class="" selected="selected">请选择</option><option label="已婚" value="1">已婚</option><option label="未婚" value="2">未婚</option><option label="离异" value="3">离异</option></select> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> <sup class="text-danger">*</sup> 最新护照号码 <br>
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
                                        <button type="button" class="btn btn-default dropdown-toggle btn-date-picker col-sm-12 ng-pristine ng-untouched ng-valid ng-binding ng-isolate-scope ng-empty ng-valid-date" dropdown-toggle="" uib-datepicker-popup="" ng-model="$info.basic.passport_expiration_date" id="passport_date" show-button-bar="false"> 请选择时间 </button>
                                        <div uib-datepicker-popup-wrap="" ng-model="date" ng-change="dateSelection(date)"  class="ng-pristine ng-untouched ng-valid ng-scope ng-empty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- ngIf: $info.immigration.length -->
                    <div class="row">
                        <div class="form-group text-center col-sm-12">
                            <button class="btn btn-primary btn-submit" type="submit" onclick="save_basic_info()">保存</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab3_3">
                <div class="col-sm-12">
                    <a  type="button" class="pull-right ng-scope" data-toggle="modal" data-target="#add_school_portal"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增选校 </a>
                    <section class="panel">
                        <div class="panel-body">
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
            <div class="tab-pane" id="tab3_4"></div>
            <div class="tab-pane" id="tab3_5"></div>
            <div class="tab-pane" id="tab3_6"></div>
            {*<div class="tab-pane fade in active" id="tab3_6">*}
                {*<div class="row">*}
                    {*<div class="col-lg-8">*}
                        {*<section>*}
                            {*<div class="panel-body">*}
                                {*<form>*}
                                    {*<input type="hidden" id='id' value="{$customer_info['id']}">*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">申请人姓名</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='name_default' value="{$customer_info['name']}">*}
                                            {*<label id="name">{$customer_info['name']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">合同ID</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='contract_id_default' value="{$customer_info['contract_id']}">*}
                                            {*<label id="contract_id">{$customer_info['contract_id']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">联系方式</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='phone_default' value="{$customer_info['phone']}">*}
                                            {*<label id="phone">{$customer_info['phone']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">申请国家</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='apply_country_default' value="{$customer_info['apply_country']}">*}
                                            {*<label id="apply_country">{$customer_info['apply_country']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">申请项目</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='apply_project_default' value="{$customer_info['apply_project']}">*}
                                            {*<label id="apply_project">{$customer_info['apply_project']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">服务类型</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='service_type_default' value="{$customer_info['service_type']}">*}
                                            {*<label id="service_type">{$customer_info['service_type']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">出国年份</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='go_abroad_year_default' value="{$customer_info['go_abroad_year']}">*}
                                            {*<label id="go_abroad_year">{$customer_info['go_abroad_year']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">微信号</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='wechat_default' value="{$customer_info['wechat']}">*}
                                            {*<label id="wechat">{$customer_info['wechat']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">申请状态</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='apply_status_default' value="{$customer_info['apply_status']}">*}
                                            {*<label id="apply_status">{$customer_info['apply_status']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">签证状态</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='visa_status_default' value="{$customer_info['visa_status']}">*}
                                            {*<label id="visa_status">{$customer_info['visa_status']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">结案状态</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='close_case_status_default' value="{$customer_info['close_case_status']}">*}
                                            {*<label id="close_case_status">{$customer_info['close_case_status']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<label class="col-sm-3 control-label col-lg-3">沟通跟进</label>*}
                                        {*<div class="input-group m-bot15">*}
                                            {*<input type="hidden" id='communication_default' value="{$customer_info['communication']}">*}
                                            {*<label id="communication">{$customer_info['communication']}</label>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="form-group">*}
                                        {*<button type="button" class="btn btn-primary" id="alter_cancel_base_info" onclick="alter_info()">*}
                                            {*修改*}
                                        {*</button>*}
                                        {*<button type="button" class="btn btn-primary" onclick="commit_info()">*}
                                            {*保存*}
                                        {*</button>*}
                                    {*</div>*}
                                {*</form>*}
                            {*</div>*}
                        {*</section>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
        </div>
    </div>
</div>
<div class="modal fade " id="add_school_portal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <form id="formSelection"  class="form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-maxlength ng-valid-date ng-valid-url" novalidate="" style="padding-bottom:50px">
                <section class="section-form">
                    <header>
                        <h4> <span class="header-title-block"></span>选校信息 </h4> <hr>
                    </header>
                    <div class="row form-fields"> <!-- ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --><!-- ngIf: vm.model -->
                        <div class="col-md-6 ng-scope"  ng-if="vm.model" ng-repeat="col in vm.schoolInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field;bindModel=vm.model">
                            <label  class="col-md-3 control-label ng-binding required"> 学校名称 </label>
                            <div class="col-md-8">
                                <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name">
                                    <input id="school_name" type="text"  ng-model="locals.model"  typeahead-loading="loadingOptions" typeahead-no-results="noResults" typeahead-template-url="customTemplate.html" ng-required="required" class="form-control dynamic-search ng-pristine ng-empty ng-valid ng-valid-required ng-touched" aria-autocomplete="list" aria-expanded="false" aria-owns="typeahead-2019-5730" style="">
                                </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngIf: vm.model --><!-- end ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --><!-- ngIf: vm.model -->
                        <div class="col-md-6 ng-scope" ng-if="vm.model" ng-repeat="col in vm.schoolInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field;bindModel=vm.model">
                            <label  class="col-md-3 control-label ng-binding"> 校区名称 </label> <div class="col-md-8"> <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name">
                                    <input ng-switch-when="text" ng-model="model[options.field]" id="school_area" placeholder="请输入校区名称" class="form-control ng-pristine ng-untouched ng-scope ng-empty ng-valid ng-valid-required" type="text" ng-disabled="options.disabled" ng-required="options.required"><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: url --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker --> </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngIf: vm.model --><!-- end ngRepeat: col in vm.schoolInfoFields | filter: vm.hasField(vm.country) --><!-- ngIf: vm.model -->
                        <div class="col-md-6 ng-scope" ng-if="vm.model" ng-repeat="col in vm.schoolInfoFields | filter: vm.hasField(vm.country)" ng-init="name=col.field;bindModel=vm.model"> <label  class="col-md-3 control-label ng-binding required"> 入学时间 </label> <div class="col-md-8"> <div on="options.type" ng-switch="" class="control ng-isolate-scope" model="bindModel" conf-options="controlOptions"  on-reload="col.onReload()" id="name"> <!-- ngSwitchWhen: text --> <!-- ngSwitchWhen: url --> <!-- ngSwitchWhen: number --> <!-- ngSwitchWhen: select -->
                                    <div on="type" ng-switch="" class="ss-dmc-control ng-isolate-scope ng-not-empty ng-valid ng-valid-required" ng-switch-when="select" type="'select'" has-depend="options.hasDepend" depend-on="options.dependOn" options="options.options" params="options.params" code="options.code" ng-model="model[options.field]" id="school_type" value-field="options.valueField" ng-required="options.required" required="required"> <!-- ngSwitchWhen: select -->
                                        <select ng-switch-when="select" id="admission_time" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-empty"><option value="" class="" selected="selected">请选择</option><option label="2016" value="string:2016">2016</option><option label="2017" value="string:2017">2017</option><option label="2018" value="string:2018">2018</option><option label="2019" value="string:2019">2019</option><option label="2020" value="string:2020">2020</option><option label="2021" value="string:2021">2021</option></select>
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
                                    <button type="button" class="btn btn-default dropdown-toggle btn-date-picker ng-pristine ng-untouched ng-binding ng-isolate-scope ng-empty ng-valid ng-valid-required ng-valid-date"  dropdown-toggle="" uib-datepicker-popup="" ng-model="apply_major.apply_end_time" show-weeks="false" is-open="visitDateOpened" ng-disabled="!apply_major.apply_batch &amp;&amp;  vm.selectionCountry === '美国'" ng-click="visitDateOpened = true" id="apply_end_time0" show-button-bar="false" ng-required="vm.selectionCountry !== '英国'">
                                        请选择时间
                                    </button>
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
                                        <select id="practice" ng-switch-when="select" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-empty"><option value="" class="" selected="selected">请选择</option><option label="是" value="boolean:true">是</option><option label="否" value="boolean:false">否</option>
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
                                        <select id="honor" ng-switch-when="select" ng-model="locals.model" ng-change="onChanged();" ng-options="option[valueField || 'name'] as option.name for option in options" ng-disabled="isDisabled || disabled" class="form-control ng-pristine ng-untouched ng-valid ng-scope ng-empty"><option value="" class="" selected="selected">请选择</option><option label="是" value="boolean:true">是</option><option label="否" value="boolean:false">否</option></select><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi -->
                                    </div><!-- end ngSwitchWhen: --> <!-- ngSwitchWhen: multi --> <!-- ngSwitchWhen: date --> <!-- ngSwitchWhen: school-picker -->
                                </div> <!-- ngIf: col.helper -->
                            </div>
                        </div><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) --><!-- end ngRepeat: col in vm.majorInfoFields | filter: vm.hasField(vm.country) -->
                        <div class="col-md-6" > <label class="col-md-3 control-label">备注</label> <div class="col-md-8"> <textarea ng-model="apply_major.remark" id="remark_0" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength" rows="4" ng-maxlength="400" placeholder="该选校的特别注意事项等备注，会在定校书中体现"></textarea> <span class="help-block">最多输入400个字</span>
                            </div>
                        </div> <!-- ngIf: $index!==0 -->
                    </div><!-- end ngRepeat: apply_major in vm.model.apply_majors track by $index --> <!-- ngIf: !vm.isEditMode -->
                    <div ng-if="!vm.isEditMode" class="ng-scope">
                        <a ng-click="vm.addMajorSection()" class="col-md-offset-1 btn btn-primary" href="">添加课程专业</a>
                    </div><!-- end ngIf: !vm.isEditMode -->
                </section>
                <hr>
                <div class="col-md-12 text-center buttons">
                    <button class="btn btn-primary" onclick="add_school()">保存</button>
                    <a ng-click="vm.$uibModalInstance.close();" class="btn btn-default" href="">取消</a>
                </div>
            </form>
        </div>
    </div>
    </div>
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

    function alter_info() {
        var name = $("#name").text();
        $("#name").replaceWith("<input id='name' value='" + name + "'>");
        contract_id = $("#contract_id").text();
        $("#contract_id").replaceWith("<input id='contract_id' value='" + contract_id + "'>");
        phone = $("#phone").text();
        $("#phone").replaceWith("<input id='phone' value='" + phone + "'>");
        apply_country = $("#apply_country").text();
        $("#apply_country").replaceWith("<input id='apply_country' value='" + apply_country + "'>");
        apply_project = $("#apply_project").text();
        $("#apply_project").replaceWith("<input id='apply_project' value='" + apply_project + "'>");
        service_type = $("#service_type").text();
        $("#service_type").replaceWith("<input id='service_type' value='" + service_type + "'>");
        go_abroad_year = $("#go_abroad_year").text();
        $("#go_abroad_year").replaceWith("<input id='go_abroad_year' value='" + go_abroad_year + "'>");
        wechat = $("#wechat").text();
        $("#wechat").replaceWith("<input id='wechat' value='" + wechat + "'>");
        communication = $("#communication").text();
        $("#communication").replaceWith("<input id='communication' value='" + communication + "'>");
        $("#alter_cancel_base_info").replaceWith('<button type="button" class="btn btn-primary" id="alter_cancel_base_info" onclick="cancel_info()">取消</button>');
    }

    function cancel_info() {
        var name = $("#name_default").val();
        $("#name").replaceWith("<label id='name'>" + name + "</label>");
        contract_id = $("#contract_id_default").val();
        $("#contract_id").replaceWith("<label id='contract_id'>" + contract_id + "</label>");
        phone = $("#phone_default").val();
        $("#phone").replaceWith("<label id='phone'>" + phone + "</label>");
        apply_country = $("#apply_country_default").val();
        $("#apply_country").replaceWith("<label id='apply_country'>" + apply_country + "</label>");
        apply_project = $("#apply_project_default").val();
        $("#apply_project").replaceWith("<label id='apply_project'>" + apply_project + "</label>");
        service_type = $("#service_type_default").val();
        $("#service_type").replaceWith("<label id='service_type'>" + service_type + "</label>");
        go_abroad_year = $("#go_abroad_year_default").val();
        $("#go_abroad_year").replaceWith("<label id='go_abroad_year'>" + go_abroad_year + "</label>");
        wechat = $("#wechat_default").val();
        $("#wechat").replaceWith("<label id='wechat'>" + wechat + "</label>");
        communication = $("#communication_default").val();
        $("#communication").replaceWith("<label id='communication'>" + communication + "</label>");
        $("#alter_cancel_base_info").replaceWith("<button type='button' class='btn btn-primary' id='alter_cancel_base_info' onclick='alter_info()'>修改</button>");
    }

    //保存客户基本信息
    function save_basic_info() {
        var id = {$basic_info['id']};
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
                    var reload_uri = "http://"+window.location.host+"/page/customer/info?id=" + id;
                    window.location.href=reload_uri;
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
        var school_name = $("#school_name").val();
        var school_area = $("#school_area").val();
        var degree = $("#degree").val();
        var admission_time = $("#admission_time").val();
        var c_class = $("#class").val();
        var profession_name = $("#profession_name").val();
        var link = $("#link").val();
        var end_time = $("#end_time").val();
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
                    var reload_uri = "http://"+window.location.host+"/page/customer/info?id=" + customer_id;
                    window.location.href=reload_uri;
                }else {
                    alert(result.error.returnUserMessage);
                }
            },
            error:function(result) {
                alert("系统异常");
            }
        });
    }
</script>

{include "layout/footer.tpl"}

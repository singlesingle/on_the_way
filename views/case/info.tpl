{include "layout/header.tpl"}

<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/static/css/jquery.datetimepicker.css"/>
<link href="/static/bk/css/bk_app_theme.css" rel="stylesheet" type="text/css" />

<div class="col-lg-12">
    <div class="alert alert-success bootstrap-admin-alert">
        <h4>案例详情</h4>
    </div>
    <div class="panel-body">
        <div class="col-lg-12">
            <section>
                <b>捷报标题</b>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">捷报标题</label>
                        <div class="input-group m-bot15">
                            <input type="hidden" id='title_default' value="{$case_info['title']}">
                            <label id="title">{$case_info['title']}</label>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <section>
                <b>学生信息</b>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">客户姓名</label>
                        <div class="input-group m-bot15">
                            <input type="hidden" id='name_default' value="{$customer_info['name']}">
                            <label id="name">{$customer_info['name']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">客户常住地</label>
                        <div class="input-group m-bot15">
                            <input type="hidden" id='often_address_default' value="">
                            <label id="often_address"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">所处阶段</label>
                        <div class="input-group m-bot15">
                            <input type="hidden" id='suochujieduan_default' value="">
                            <label id="suochujieduan"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">申请国家</label>
                        <div class="input-group m-bot15">
                            <input type="hidden" id='apply_country_default' value="{$customer_info['apply_country']}">
                            <label id="apply_country">{$customer_info['apply_country']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">申请项目</label>
                        <div class="input-group m-bot15">
                            <input type="hidden" id='apply_project_default' value="{$customer_info['apply_project']}">
                            <label id="apply_project">{$customer_info['apply_project']}</label>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <section>
                <b>教育经历</b>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">就读时间</label>
                        <div class="input-group m-bot15">
                            <label id="1name">{$education_info['start_time']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">学历阶段</label>
                        <div class="input-group m-bot15">
                            <label id="1name">{$education_info['level']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">当前情况</label>
                        <div class="input-group m-bot15">
                            <label id="1name">无</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">就读地点</label>
                        <div class="input-group m-bot15">
                            <label id="1name">{$education_info['address']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">就读学校</label>
                        <div class="input-group m-bot15">
                            <label id="1name">{$education_info['school_name']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">学校层级</label>
                        <div class="input-group m-bot15">
                            <label id="1name">{$education_info['type']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">就读院系</label>
                        <div class="input-group m-bot15">
                            <label id="1name"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">就读专业</label>
                        <div class="input-group m-bot15">
                            <label id="1name">{$education_info['major']}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">GPA类型</label>
                        <div class="input-group m-bot15">
                            <label id="1name"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">考试成绩</label>
                        <div class="input-group m-bot15">
                            <label id="1name"></label>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <section>
                <b>申请/录取信息</b>
                <div class="panel-body">
                    {foreach from=$school_info key=k item=one_broad_info}
                        {$v = $k+1}
                        <div id = 'school{$v}'>
                            <input type="hidden" id='profession_id{$v}' value="{$one_broad_info['profession_id']}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">课程类别</label>
                                <div class="input-group m-bot15" id="bb_account_f{$v}">
                                    <input type="hidden" id='apply_project_default{$v}' value="{$one_broad_info['apply_project']}">
                                    <label id="apply_project{$v}">{$one_broad_info['apply_project']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">计划留学时间</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='admission_time_default{$v}' value="{$one_broad_info['admission_time']}">
                                    <label id="admission_time{$v}">{$one_broad_info['admission_time']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">申请学校</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='school_name_default{$v}' value="{$one_broad_info['school_name']}">
                                    <label id="school_name{$v}">{$one_broad_info['school_name']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">专业分类</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='class_default{$v}' value="{$one_broad_info['class']}">
                                    <label id="class{$v}">{$one_broad_info['class']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">专业名称</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='profession_name_default{$v}' value="{$one_broad_info['profession_name']}">
                                    <label id="profession_name{$v}">{$one_broad_info['profession_name']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">录取结果</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='result_default{$v}' value="{$one_broad_info['result']}">
                                    <label id="result{$v}">{$one_broad_info['result']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">是否有奖学金</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='honors_default{$v}' value="{$one_broad_info['honors']}">
                                    <label id="honors{$v}">{$one_broad_info['honors']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">offer通知时间</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='offer_time_default{$v}' value="{$one_broad_info['offer_time']}">
                                    <label id="offer_time_name{$v}">{$one_broad_info['offer_time']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">是否最终入读</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='is_sure_default{$v}' value="{$one_broad_info['is_sure']}">
                                    <label id="is_sure{$v}">{$one_broad_info['is_sure']}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">offer附件</label>
                                <div class="input-group m-bot15">
                                    <input type="hidden" id='offer_file_default{$v}' value="{$one_broad_info['offer_file']}">
                                    <label id="offer_file{$v}">{$one_broad_info['offer_file']}</label>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </section>
        </div>
    </div>
</div>
<script>

    function alterBroadband(id) {
        bb_account_id = "bb_account" + id;
        bb_account = $("#" + bb_account_id).text();
        $("#" + bb_account_id).replaceWith("<input id='" + bb_account_id + "' value='" + bb_account + "'>");
        bb_width_id = "bb_width" + id;
        bb_width = $("#" + bb_width_id).text();
        $("#" + bb_width_id).replaceWith("<input id='" + bb_width_id + "' value='" + bb_width + "'>");
        bb_type_id = "bb_type" + id;
        bb_type = $("#" + bb_type_id).text();
        $("#" + bb_type_id).replaceWith("<input id='" + bb_type_id + "' value='" + bb_type + "'>");
        bb_connect_id = "bb_connect" + id;
        bb_connect = $("#" + bb_connect_id).text();
        $("#" + bb_connect_id).replaceWith("<input id='" + bb_connect_id + "' value='" + bb_connect + "'>");
        bb_static_ip_id = "bb_static_ip" + id;
        bb_static_ip = $("#" + bb_static_ip_id).text();
        $("#" + bb_static_ip_id).replaceWith("<input id='" + bb_static_ip_id + "' value='" + bb_static_ip + "'>");
        bb_mac_id = "bb_mac" + id;
        bb_mac = $("#" + bb_mac_id).text();
        $("#" + bb_mac_id).replaceWith("<input id='" + bb_mac_id + "' value='" + bb_mac + "'>");
        $("#alter_cancel" + id).replaceWith('<button type="button" class="btn btn-primary" id="alter_cancel' + id + '" onclick="cancelBroadband(' + id + ')">取消</button>');
    }

    function cancelBroadband(id) {
        bb_account_id = "bb_account_default" + id;
        account_id = "bb_account" + id;
        bb_account = $("#" + bb_account_id).val();
        $("#" + account_id).replaceWith("<label id='" + account_id + "'>" + bb_account + "</label>");
        bb_width_id = "bb_width_default" + id;
        width_id = "bb_width" + id;
        bb_width = $("#" + bb_width_id).val();
        $("#" + width_id).replaceWith("<label id='" + width_id + "'>" + bb_width + "</label>");
        bb_type_id = "bb_type_default" + id;
        type_id = "bb_type" + id;
        bb_type = $("#" + bb_type_id).val();
        $("#" + type_id).replaceWith("<label id='" + type_id + "'>" + bb_type + "</label>");
        bb_connect_id = "bb_connect_default" + id;
        connect_id = "bb_connect" + id;
        bb_connect = $("#" + bb_connect_id).val();
        $("#" + connect_id).replaceWith("<label id='" + connect_id + "'>" + bb_connect + "</label>");
        bb_static_ip_id = "bb_static_ip_default" + id;
        static_ip_id = "bb_static_ip" + id;
        bb_static_ip = $("#" + bb_static_ip_id).val();
        $("#" + static_ip_id).replaceWith("<label id='" + static_ip_id + "'>" + bb_static_ip + "</label>");
        bb_mac_id = "bb_mac_default" + id;
        mac_id = "bb_mac" + id;
        bb_mac = $("#" + bb_mac_id).val();
        $("#" + mac_id).replaceWith("<label id='" + mac_id + "'>" + bb_mac + "</label>");
        $("#alter_cancel" + id).replaceWith("<button type='button' class='btn btn-primary' id='alter_cancel" + id + "' onclick='alterBroadband(" + id + ")'>修改</button>");
    }

    function commitBroadband(id) {
        var bb_account = $("#bb_account" + id).val();
        var bb_width = $("#bb_width" + id).val();
        var bb_type = $("#bb_type" + id).val();
        var bb_connect = $("#bb_connect" + id).val();
        var bb_static_ip = $("#bb_static_ip" + id).val();
        var bb_mac = $("#bb_mac" + id).val();
        var bb_id = $("#broadband_id" + id).val();
        var uri = "http://"+window.location.host+"/api/storeapi/updatebroadband";
        $.ajax({
            url: uri,//这个就是请求地址对应sAjaxSource
            data : {
                "id":bb_id,
                'account':bb_account,
                'width':bb_width,
                'type':bb_type,
                'connect':bb_connect,
                'static_ip':bb_static_ip,
                'mac':bb_mac
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (result) {
                if (result.error.returnCode == 200) {
                    alert('修改成功');
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

    function deleteBroadband(id) {
        var bb_account = $("#bb_account" + id).text();
        var store_no = $("#store_no_default").val();
        var msg = "确定要删除账号为" + bb_account + "的宽带信息吗？";
        if (confirm(msg) == false){
            return;
        }
        var bb_id = $("#broadband_id" + id).val();
        var uri = "http://"+window.location.host+"/api/storeapi/deletebroadband";
        $.ajax({
            url: uri,//这个就是请求地址对应sAjaxSource
            data : {
                "id":bb_id,
                "store_no":store_no
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (result) {
                alert(result.error.returnUserMessage);
                window.location.reload();
            },
            error:function(result) {
                alert("系统异常");
            }
        });
    }

    function alterVpn(id) {
        brand_id = "vpn_brand" + id;
        brand = $("#" + brand_id).text();
        $("#" + brand_id).replaceWith("<input id='" + brand_id + "' value='" + brand + "'>");
        model_id = "vpn_model" + id;
        model = $("#" + model_id).text();
        $("#" + model_id).replaceWith("<input id='" + model_id + "' value='" + model + "'>");
        sn_id = "vpn_sn" + id;
        sn = $("#" + sn_id).text();
        $("#" + sn_id).replaceWith("<input id='" + sn_id + "' value='" + sn + "'>");
        $("#alter_cancel_vpn" + id).replaceWith('<button type="button" class="btn btn-primary" id="alter_cancel_vpn' + id + '" onclick="cancelVpn(' + id + ')">取消</button>');
    }

    function cancelVpn(id) {
        brand_default_id = "vpn_brand_default" + id;
        brand_id = "vpn_brand" + id;
        brand = $("#" + brand_default_id).val();
        $("#" + brand_id).replaceWith("<label id='" + brand_id + "'>" + brand + "</label>");
        model_default_id = "vpn_model_default" + id;
        model_id = "vpn_model" + id;
        model = $("#" + model_default_id).val();
        $("#" + model_id).replaceWith("<label id='" + model_id + "'>" + model + "</label>");
        sn_default_id = "vpn_sn_default" + id;
        sn_id = "vpn_sn" + id;
        sn = $("#" + sn_default_id).val();
        $("#" + sn_id).replaceWith("<label id='" + sn_id + "'>" + sn + "</label>");
        $("#alter_cancel_vpn" + id).replaceWith("<button type='button' class='btn btn-primary' id='alter_cancel_vpn" + id + "' onclick='alterVpn(" + id + ")'>修改</button>");
    }

    function commitVpn(id) {
        var brand = $("#vpn_brand" + id).val();
        var model = $("#vpn_model" + id).val();
        var sn = $("#vpn_sn" + id).val();
        var vpn_id = $("#vpn_id" + id).val();
        var uri = "http://"+window.location.host+"/api/storeapi/updatevpn";
        $.ajax({
            url: uri,//这个就是请求地址对应sAjaxSource
            data : {
                "id":vpn_id,
                'brand':brand,
                'model':model,
                'sn':sn,
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (result) {
                if (result.error.returnCode == 0 ) {
                    alert('修改成功');
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

    function alter_base_info() {
        store_name = $("#store_name").text();
        $("#store_name").replaceWith("<input id='store_name' value='" + store_name + "'>");
        store_no = $("#store_no").text();
        $("#store_no").replaceWith("<input id='store_no' value='" + store_no + "'>");
        store_net = $("#store_net").text();
        $("#store_net").replaceWith("<input id='store_net' value='" + store_net + "'>");
        $("#alter_cancel_base_info").replaceWith('<button type="button" class="btn btn-primary" id="alter_cancel_base_info" onclick="cancel_base_info()">取消</button>');
    }

    function cancel_base_info() {
        store_name = $("#store_name_default").val();
        $("#store_name").replaceWith("<label id='store_name'>" + store_name + "</label>");
        store_no = $("#store_no_default").val();
        $("#store_no").replaceWith("<label id='store_no'>" + store_no + "</label>");
        store_net = $("#store_net_default").val();
        $("#store_net").replaceWith("<label id='store_net'>" + store_net + "</label>");
        $("#alter_cancel_base_info").replaceWith("<button type='button' class='btn btn-primary' id='alter_cancel_base_info' onclick='alter_base_info()'>修改</button>");
    }

    //修改区域名称，门店名称
    function commit_base_info() {
        var store_name = $("#store_name").val();
        var store_no = $("#store_no").val();
        var store_net = $("#store_net").val();
        var store_id = $("#store_id").val();
        if (store_name == null || store_name == '') {
            alert('门店名不可以为空');
            return;
        }
        if (store_no == null || store_no == '') {
            alert('门店编号不可以为空');
            return;
        }
        if (store_net == null || store_net == '') {
            alert('网段不可以为空');
            return;
        }
        if( !confirm('确定要修改? ')) {
            return
        }
        var request = {
            "store_name": store_name,
            "store_no": store_no,
            "store_net": store_net,
            "store_id": store_id
        };
        var uri = "http://"+window.location.host+"/api/storeapi/alteraddress";
        $.ajax({
            url: uri,
            type: "POST",
            data: request,
            dataType:"json",
            async :false,
            success: function (result) {
                if (result.error.returnCode == 200) {
                    alert('修改成功');
                    var reload_uri = "http://"+window.location.host+"/page/storeip/netinfo?store_no=" + store_no + "&from=all";
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

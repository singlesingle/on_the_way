{include "layout/header.tpl"}

<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/static/css/jquery.datetimepicker.css"/>
<link href="/static/bk/css/bk_app_theme.css" rel="stylesheet" type="text/css" />

<div class="col-lg-12">
    <a class="king-btn-demo king-btn king-info" title="返回" href="#" onClick="javascript :history.back(-1);">
        <i class="fa fa-mail-reply-all btn-icon" ></i>返回
    </a>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success bootstrap-admin-alert">
                <h4>客户详细信息</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <section>
                <div class="panel-body">
                    <form>
                        <input type="hidden" id='id' value="{$customer_info['id']}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">申请人姓名</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='name_default' value="{$customer_info['name']}">
                                <label id="name">{$customer_info['name']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">合同ID</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='contract_id_default' value="{$customer_info['contract_id']}">
                                <label id="contract_id">{$customer_info['contract_id']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">联系方式</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='phone_default' value="{$customer_info['phone']}">
                                <label id="phone">{$customer_info['phone']}</label>
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">服务类型</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='service_type_default' value="{$customer_info['service_type']}">
                                <label id="service_type">{$customer_info['service_type']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">出国年份</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='go_abroad_year_default' value="{$customer_info['go_abroad_year']}">
                                <label id="go_abroad_year">{$customer_info['go_abroad_year']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">签约业务线</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='line_business_default' value="{$customer_info['line_business']}">
                                <label id="line_business">{$customer_info['line_business']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">微信号</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='wechat_default' value="{$customer_info['wechat']}">
                                <label id="wechat">{$customer_info['wechat']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">绑定微信</label>
                            <div class="input-group m-bot15">
                                <label id="bind_wechat">{$customer_info['bind_wechat']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">选校状态</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='select_check_default' value="{$customer_info['select_check']}">
                                <label id="select_check">{$customer_info['select_check']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">申请状态</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='apply_status_default' value="{$customer_info['apply_status']}">
                                <label id="apply_status">{$customer_info['apply_status']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">签证状态</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='visa_status_default' value="{$customer_info['visa_status']}">
                                <label id="visa_status">{$customer_info['visa_status']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">结案状态</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='close_case_status_default' value="{$customer_info['close_case_status']}">
                                <label id="close_case_status">{$customer_info['close_case_status']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">结案类型</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='close_case_type_default' value="{$customer_info['close_case_type']}">
                                <label id="close_case_type">{$customer_info['close_case_type']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">沟通跟进</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='communication_default' value="{$customer_info['communication']}">
                                <label id="communication">{$customer_info['communication']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="alter_cancel_base_info" onclick="alter_info()">
                                修改
                            </button>
                            <button type="button" class="btn btn-primary" onclick="commit_info()">
                                保存
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<script>

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
        line_business = $("#line_business").text();
        $("#line_business").replaceWith("<input id='line_business' value='" + line_business + "'>");
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
        line_business = $("#line_business_default").val();
        $("#line_business").replaceWith("<label id='line_business'>" + line_business + "</label>");
        wechat = $("#wechat_default").val();
        $("#wechat").replaceWith("<label id='wechat'>" + wechat + "</label>");
        communication = $("#communication_default").val();
        $("#communication").replaceWith("<label id='communication'>" + communication + "</label>");
        $("#alter_cancel_base_info").replaceWith("<button type='button' class='btn btn-primary' id='alter_cancel_base_info' onclick='alter_info()'>修改</button>");
    }

    //修改区域名称，门店名称
    function commit_info() {
        var id = $("#id").val();
        var name = $("#name").val();
        var contract_id = $("#contract_id").val();
        var phone = $("#phone").val();
        var apply_country = $("#apply_country").val();
        var apply_project = $("#apply_project").val();
        var service_type = $("#service_type").val();
        var go_abroad_year = $("#go_abroad_year").val();
        var line_business = $("#line_business").val();
        var wechat = $("#wechat").val();
        var communication = $("#communication").val();
        if (id == '' || name == '' || contract_id == '' || phone == '' || apply_country == '' || apply_project == '' ||
            service_type == '' || go_abroad_year == '' || line_business == '' || wechat == '' || communication == '' ) {
            alert('必填项不可以为空');
            return;
        }
        var request = {
            "id": id,
            "name": name,
            "contract_id": contract_id,
            "phone": phone,
            "apply_country": apply_country,
            "apply_project": apply_project,
            "service_type": service_type,
            "go_abroad_year": go_abroad_year,
            "line_business": line_business,
            "wechat": wechat,
            "communication": communication,
        };
        var uri = "http://"+window.location.host+"/api/customer/update";
        $.ajax({
            url: uri,
            type: "POST",
            data: request,
            dataType:"json",
            async :false,
            success: function (result) {
                if (result.error.returnCode == 0) {
                    alert('修改成功');
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
</script>

{include "layout/footer.tpl"}

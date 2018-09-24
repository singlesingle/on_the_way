{include "layout/header.tpl" }
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/static/css/jquery.datetimepicker.css"/>
<link href="/static/bk/css/bk_app_theme.css" rel="stylesheet" type="text/css" />

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success bootstrap-admin-alert">
                <h4>个人信息维护</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <section>
                <div class="panel-body">
                    <form>
                        <input type="hidden" id='id' value="{$user_info['id']}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">姓名</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='name_default' value="{$user_info['name']}">
                                <label id="name">{$user_info['name']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">联系方式</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='phone_default' value="{$user_info['phone']}">
                                <label id="phone">{$user_info['phone']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">岗位</label>
                            <div class="input-group m-bot15">
                                <label id="role">{$user_info['role']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">上级</label>
                            <div class="input-group m-bot15">
                                <label id="leader">{$user_info['leader']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label col-lg-3">个人介绍</label>
                            <div class="input-group m-bot15">
                                <input type="hidden" id='introduce_default' value="{$user_info['introduce']}">
                                <label id="introduce">{$user_info['introduce']}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm" id="alter_cancel_base_info" onclick="alter_info()">
                                修改
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="commit_info()">
                                保存
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#alter_pwd_page">
                                修改密码
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="alter_pwd_page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">新密码：</label>
                        <div class="col-sm-6">
                            <input type="text"  class="form-control" id="pwd">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="alter_pwd()">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>

    function alter_info() {
        var name = $("#name").text();
        $("#name").replaceWith("<input id='name' value='" + name + "'>");
        phone = $("#phone").text();
        $("#phone").replaceWith("<input id='phone' value='" + phone + "'>");
        introduce = $("#introduce").text();
        $("#introduce").replaceWith("<input id='introduce' value='" + introduce + "'>");
        $("#alter_cancel_base_info").replaceWith('<button type="button" class="btn btn-primary" id="alter_cancel_base_info" onclick="cancel_info()">取消</button>');
    }

    function cancel_info() {
        var name = $("#name_default").val();
        $("#name").replaceWith("<label id='name'>" + name + "</label>");
        phone = $("#phone_default").val();
        $("#phone").replaceWith("<label id='phone'>" + phone + "</label>");
        introduce = $("#introduce_default").val();
        $("#introduce").replaceWith("<label id='introduce'>" + introduce + "</label>");
        $("#alter_cancel_base_info").replaceWith("<button type='button' class='btn btn-primary' id='alter_cancel_base_info' onclick='alter_info()'>修改</button>");
    }

    function commit_info() {
        var id = $("#id").val();
        var name = $("#name").val();
        var phone = $("#phone").val();
        var introduce = $("#introduce").val();
        if (id == '' || name == '' || phone == '' || introduce == '') {
            alert('必填项不可以为空');
            return;
        }
        var request = {
            "user_id": id,
            "name": name,
            "phone": phone,
            "introduce": introduce,
        };
        var uri = "http://"+window.location.host+"/api/user/update";
        $.ajax({
            url: uri,
            type: "POST",
            data: request,
            dataType:"json",
            async :false,
            success: function (result) {
                if (result.error.returnCode == 0) {
                    alert('修改成功');
                    var reload_uri = "http://"+window.location.host+"/page/user/info";
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

    function alter_pwd() {
        var pwd = $("#pwd").val();
        if (pwd == '') {
            alert('必填项不可以为空');
            return;
        }
        var request = {
            "pwd": pwd,
        };
        var uri = "http://"+window.location.host+"/api/user/pwd";
        $.ajax({
            url: uri,
            type: "POST",
            data: request,
            dataType:"json",
            async :false,
            success: function (result) {
                if (result.error.returnCode == 0) {
                    alert('修改成功');
                    var reload_uri = "http://"+window.location.host+"/page/user/info";
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
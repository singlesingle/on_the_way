{include "layout/header.tpl" }
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/jquery.dataTables.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/dataTables.bootstrap.js"></script>
<script src="/static/js/select2/select2.js"></script>
<link href="/static/js/select2/select2.css" rel="stylesheet">
<style>
    pre { outline: 0px solid #f0f0f0; padding: 5px; margin: 5px; background-color:#ffffff; color: #9b9b9b
    }
    .row {
        margin-left: 0px;
    }
    .form-control {
        border: 1px solid #9b9b9b;
        color: #1a2226;
    }
</style>
<div class="col-sm-12">
    <section class="panel">
        <header class="panel-heading">
            我的案例
            <a type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_user_portal">新增</a>
        </header>
        <div class="panel-body">
                <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>标题</th>
                        <th>学生姓名</th>
                        <th>申请国家</th>
                        <th>申请项目</th>
                        <th>申请学校</th>
                        <th>创建时间</th>
                        <th>审核通过时间</th>
                        <th>案例状态</th>
                        <th>审核备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $case_list as $one}
                        <tr>
                            <td>{$one['title']}</td>
                            <td>{$one['name']}</td>
                            <td>{$one['apply_country']}</td>
                            <td>{$one['apply_project']}</td>
                            <td>{$one['admission_school']}</td>
                            <td>{$one['create_time']}</td>
                            <td>{$one['check_pass_time']}</td>
                            <td>{$one['close_case_status']}</td>
                            <td>{$one['summary']}</td>
                            <td>
                                <a type="button" class="btn btn-sm btn-info" onclick="enable_user('{$one['id']}')">修改</a>&nbsp&nbsp
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
        </div>
    </section>
</div>

<div class="modal fade" id="add_user_portal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    创建案例
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">用户名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="service_name">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">手机号：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="domain_name" placeholder="多个域名以“,”分割">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">岗位：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="group_name">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="create_user()">
                    创建
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="transfer_position" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    修改案例
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">用户名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="user_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">原上级领导：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="domain_name" placeholder="多个域名以“,”分割">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">新上级领导：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="group_name">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="transfer_user()">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript">
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

    function create_user() {
        var name = '';
        var phone = '';
        var role = '';
        if(confirm('确定要创建此用户吗?')) {
            $.ajax({
                url: '/api/user/adduser',
                type: "POST",
                data: {
                    'name': name,
                    'phone': phone,
                    'role': role,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('创建用户成功！');
                        window.location.reload();
                    }else {
                        alert('创建用户失败！');
                    }
                },
                error: function (data) {
                    alert('创建用户异常！');
                }
            });
        }
    }

    function disable_user(id) {
        if(confirm('确定要禁用此用户吗?')) {
            $.ajax({
                url: '/api/user/disuser',
                type: "POST",
                data: {
                    'user_id': id,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('禁用成功！');
                        window.location.reload();
                    }else {
                        alert('禁用失败！');
                    }
                },
                error: function (data) {
                    alert('禁用异常！');
                }
            });
        }
    }

    function enable_user(id) {
        if(confirm('确定要启用此用户吗?')) {
            $.ajax({
                url: '/api/user/disuser',
                type: "POST",
                data: {
                    'user_id': id,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('启用成功！');
                        window.location.reload();
                    }else {
                        alert('启用失败！');
                    }
                },
                error: function (data) {
                    alert('启用异常！');
                }
            });
        }
    }

    function delete_user(id) {
        if(confirm('确定要删除此用户吗?')) {
            $.ajax({
                url: '/api/user/deleteuser',
                type: "POST",
                data: {
                    'user_id': id,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('删除成功！');
                        window.location.reload();
                    }else {
                        alert('删除失败！');
                    }
                },
                error: function (data) {
                    alert('删除异常！');
                }
            });
        }
    }

    function transfer_user() {
        user_id = '';
        leader_user_id = '';
        if(confirm('确定要将此用户转岗吗?')) {
            $.ajax({
                url: '/api/user/transfer',
                type: "POST",
                data: {
                    'user_id': user_id,
                    'leader_user_id': leader_user_id,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('转岗成功！');
                        window.location.reload();
                    }else {
                        alert('转岗失败！');
                    }
                },
                error: function (data) {
                    alert('转岗异常！');
                }
            });
        }
    }
</script>
{include "layout/footer.tpl"}
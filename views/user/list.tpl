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
            用户列表
            <a type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addUserPortal">创建</a>
        </header>
        <div class="panel-body">
                <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>用户名</th>
                        <th>联系方式</th>
                        <th>岗位</th>
                        <th>上级</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $user_list as $one}
                        <tr>
                            <td>{$one['name']}</td>
                            <td>{$one['phone']}</td>
                            <td>{$one['role']}</td>
                            <td>{$one['leader']}</td>
                            <td>{$one['status']}</td>
                            <td>{$one['create_time']}</td>
                            <td>
                                {if $one['status'] == '禁用'}
                                    <a type="button" class="btn btn-sm btn-info" onclick="enable_user('{$one['id']}')">启用</a>&nbsp&nbsp
                                {else}
                                    <a type="button" class="btn btn-sm btn-info" onclick="disable_user('{$one['id']}')">禁用</a>&nbsp&nbsp
                                {/if}
                                {if $one['role'] != '管理员'}
                                <a type="button" class="btn btn-sm btn-danger" onclick="delete_user('{$one['id']}')">删除</a>
                                {/if}
				{if $one['role'] != '管理员' and $one['role'] == '文案人员'}
                                    <a type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#transfer_position">调岗</a>&nbsp
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
        </div>
    </section>
</div>

<div class="modal fade" id="addUserPortal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    创建用户
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">用户名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_user_name">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">手机号：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_phone" placeholder="多个域名以“,”分割">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">岗位：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_role">
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
                    调转岗位
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
        var name = $('#add_user_name').val().trim();;
        var phone = $('#add_phone').val().trim();;
        var role = $('#add_role').val().trim();;
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
                url: '/api/user/enableuser',
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

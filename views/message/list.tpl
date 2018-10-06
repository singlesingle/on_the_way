{include "layout/header.tpl" }
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/jquery.dataTables.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/dataTables.bootstrap.js"></script>
<script src="/static/js/select2/select2.js"></script>
<link href="/static/select2/select2.css" rel="stylesheet" type="text/css" />
<link href="/static/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/daterangepicker.css" rel="stylesheet">
<div class="col-sm-12">
    <section class="panel">
        <div class="panel-body">
            <laber style="font-size:large">系统消息列表</laber>
            <a type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#add_document_portal">创建</a>
            <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>标题</th>
                        <th width="60%">内容</th>
                        <th>是否发布</th>
                        <th>创建时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $list as $one}
                        <tr>
                            <td>{$one['title']}</td>
                            <td>{$one['content']}</td>
                            <td>{$one['status']}</td>
                            <td>{$one['create_time']}</td>
                            <td>
                                {if $one['status'] == '否'}
                                <a type="button" class="btn btn-sm btn-danger" onclick="release_msg('{$one['id']}')">发布</a>
                                {/if}
                                <a type="button" class="btn btn-sm btn-danger" onclick="delete_msg('{$one['id']}')">删除</a>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
        </div>
    </section>
</div>

<div class="modal fade" id="add_document_portal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    创建消息
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">标题：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">内容：</label>
                        <textarea class="form-control" rows="17" style="width:400px;" id="content"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="add_message()">
                    创建
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

    function add_message() {
        var title = $('#title').val().trim();
        var content = $('#content').val().trim();
        if(confirm('确定要新增此文书吗?')) {
            $.ajax({
                url: '/api/message/add',
                type: "POST",
                data: {
                    'title': title,
                    'content': content
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('创建消息成功！');
                        window.location.reload();
                    }else {
                        alert('创建消息失败！');
                    }
                },
                error: function (data) {
                    alert('创建消息异常！');
                }
            });
        }
    }

    function release_msg(id) {
        if(confirm('确定要发布此系统消息吗?')) {
            $.ajax({
                url: '/api/message/release',
                type: "POST",
                data: {
                    'message_id': id
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('消息发布成功！');
                        window.location.reload();
                    }else {
                        alert('消息发布失败！');
                    }
                },
                error: function (data) {
                    alert('消息发布异常！');
                }
            });
        }
    }

    function delete_msg(id) {
        if(confirm('确定要删除此消息吗?')) {
            $.ajax({
                url: '/api/message/delete',
                type: "POST",
                data: {
                    'message_id': id
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('删除消息成功！');
                        window.location.reload();
                    }else {
                        alert('删除消息失败！');
                    }
                },
                error: function (data) {
                    alert('删除消息异常！');
                }
            });
        }
    }

</script>
{include "layout/footer.tpl"}
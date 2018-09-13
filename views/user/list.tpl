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
        </header>
        <div class="panel-body">
                <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>用户名</th>
                        <th>联系方式</th>
                        <th>岗位</th>
                        <th>上级</th>
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
                            <td>{$one['create_time']}</td>
                            <td>
                                <a type="button" class="btn btn-sm btn-info" onclick="member_admin('')">调岗</a>&nbsp&nbsp
                                <a type="button" class="btn btn-sm btn-info" onclick="config_admin('')">禁用</a>&nbsp&nbsp
                                <a type="button" class="btn btn-sm btn-danger" onclick="delete_group('')">删除</a>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
        </div>
    </section>
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
</script>
{include "layout/footer.tpl"}
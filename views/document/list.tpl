{include "layout/header.tpl" }
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/jquery.dataTables.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/dataTables.bootstrap.js"></script>
<script src="/static/js/select2/select2.js"></script>
<link href="/static/select2/select2.css" rel="stylesheet" type="text/css" />
<link href="/static/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
<div class="col-sm-12">
    <section class="panel">
        <header class="panel-heading">
            文书范例
            <a type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_document_portal">新增</a>
        </header>
        <div class="panel-body">
                <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>文书ID</th>
                        <th>学生姓名</th>
                        <th>文案姓名</th>
                        <th>申请国家</th>
                        <th>申请项目</th>
                        <th>申请学校</th>
                        <th>申请专业</th>
                        <th>文书类型</th>
                        <th>上传时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $document_list as $one}
                        <tr>
                            <td>{$one['id']}</td>
                            <td>{$one['student_name']}</td>
                            <td>{$one['name']}</td>
                            <td>{$one['apply_country']}</td>
                            <td>{$one['apply_project']}</td>
                            <td>{$one['apply_school']}</td>
                            <td>{$one['profession']}</td>
                            <td>{$one['type']}</td>
                            <td>{$one['create_time']}</td>
                            <td>
                                <a type="button" class="btn btn-sm btn-danger" onclick="enable_user('{$one['id']}')">查看</a>
                                <a type="button" class="btn btn-sm btn-danger" onclick="enable_user('{$one['id']}')">上传文件</a>
                                <a type="button" class="btn btn-sm btn-danger" onclick="enable_user('{$one['id']}')">删除</a>
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
                    新增文书
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">客户：</label>
                        <div id="add_customer_id" class="col-sm-6">
                            <input type="hidden" class="select2_box" id="customer_id" style="width:260px;">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">文案姓名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_name">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请学校：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_apply_school">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请专业：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_profession">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">文书类型：</label>
                        <select id="add_type" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">简历</option>
                            <option value="2">推荐信</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="add_document()">
                    新增
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

    $("#add_customer_id .select2_box").select2({
        ajax: {
            url: "/api/customer/list",
            dataType: "json",
            data: function(params){
                return {
                    // city_name : params//此处是最终传递给API的参数
                }
            },
            //对返回的数据进行处理
            results: function(data){
                var json = eval(data);
                return json.data;
            }
        }
    });

    function add_document() {
        var customer_id = $('#customer_id').val().trim();
        var name = $('#add_name').val().trim();
        var apply_school = $('#add_apply_school').val().trim();
        var profession = $('#add_profession').val().trim();
        var type = $('#add_type').val().trim();
        if(confirm('确定要新增此文书吗?')) {
            $.ajax({
                url: '/api/document/add',
                type: "POST",
                data: {
                    'customer_id': customer_id,
                    'name': name,
                    'apply_school': apply_school,
                    'profession': profession,
                    'type': type,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('添加客户成功！');
                        window.location.reload();
                    }else {
                        alert('添加客户失败！');
                    }
                },
                error: function (data) {
                    alert('添加客户异常！');
                }
            });
        }
    }
</script>
{include "layout/footer.tpl"}
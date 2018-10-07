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
            <laber style="font-size:large">我的案例</laber>
            <a type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#add_user_portal">新增</a>
            <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>标题</th>
                        <th>学生姓名</th>
                        <th>申请国家</th>
                        <th>申请项目</th>
                        <th>申请学校</th>
                        <th>创建时间</th>
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
                            <td>{$one['close_case_status']}</td>
                            <td>{$one['summary']}</td>
                            <td>
                                <a type="button" class="btn btn-sm btn-danger" href="/page/case/info?id={$one['case_id']}">预览</a>
                                <a type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#update_case_portal"
                                   onclick="update_case_page('{$one['case_id']}','{$one['title']}','{$one['admission_school']}','{$one['rank']}','{$one['profession']}','{$one['result']}','{$one['entry_time']}','{$one['graduated_school']}','{$one['summary']}')">编辑</a>&nbsp&nbsp
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
                        <label class="col-sm-3 control-label">客户：</label>
                        <div id="add_customer_id" class="col-sm-6">
                            <input type="hidden" class="select2_box" id="customer_id" style="width:260px;">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">标题：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_title">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请学校：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_admission_school">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">学校排名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_rank">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">录取专业：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_profession">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">录取结果：</label>
                        <select id="add_result" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">录取</option>
                            <option value="2">未录取</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">入读时间：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_entry_time">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">就读/毕业院校：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_graduated_school">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">干货总结：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_summary">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="create_case()">
                    新增
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="update_case_portal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <input type="hidden" class="form-control" id="update_case_id">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">标题：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="update_title">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请学校：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="update_admission_school">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">学校排名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="update_rank">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">录取专业：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="update_profession">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">录取结果：</label>
                        <select id="update_result" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">录取</option>
                            <option value="2">未录取</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">入读时间：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="update_entry_time">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">就读/毕业院校：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="update_graduated_school">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">干货总结：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="update_summary">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="update_case()">
                    修改
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript">
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

    function create_case() {
        var customer_id = $("#customer_id").val();
        var title = $('#add_title').val().trim();
        var admission_school = $('#add_admission_school').val().trim();
        var rank = $('#add_rank').val().trim();
        var profession = $('#add_profession').val().trim();
        var result = $('#add_result').val().trim();
        var entry_time = $('#add_entry_time').val().trim();
        var graduated_school = $('#add_graduated_school').val().trim();
        var summary = $('#add_summary').val().trim();
        if(confirm('确定要新增此案例吗?')) {
            $.ajax({
                url: '/api/case/add',
                type: "POST",
                data: {
                    'customer_id': customer_id,
                    'title': title,
                    'admission_school': admission_school,
                    'rank': rank,
                    'profession': profession,
                    'result': result,
                    'entry_time': entry_time,
                    'graduated_school': graduated_school,
                    'summary': summary,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('创建案例成功！');
                        window.location.reload();
                    }else {
                        alert('创建案例失败！');
                    }
                },
                error: function (data) {
                    alert('创建案例异常！');
                }
            });
        }
    }
    
    function update_case_page(id, title, admission_school, rank, profession, result, entry_time, graduated_school, summary) {
        $('#update_case_id').val(id);
        $('#update_title').val(title);
        $('#update_admission_school').val(admission_school);
        $('#update_rank').val(rank);
        $('#update_profession').val(profession);
        $("#update_result option[value='"+result+"']").attr("selected","selected");
        $('#update_entry_time').val(entry_time);
        $('#update_graduated_school').val(graduated_school);
        $('#update_summary').val(summary);
    }

    function update_case() {
        var case_id = $('#update_case_id').val().trim();
        var title = $('#update_title').val().trim();
        var admission_school = $('#update_admission_school').val().trim();
        var rank = $('#update_rank').val().trim();
        var profession = $('#update_profession').val().trim();
        var result = $('#update_result').val().trim();
        var entry_time = $('#update_entry_time').val().trim();
        var graduated_school = $('#update_graduated_school').val().trim();
        var summary = $('#update_summary').val().trim();
        if(confirm('确定要修改此案例吗?')) {
            $.ajax({
                url: '/api/case/update',
                type: "POST",
                data: {
                    'case_id': case_id,
                    'title': title,
                    'admission_school': admission_school,
                    'rank': rank,
                    'profession': profession,
                    'result': result,
                    'entry_time': entry_time,
                    'graduated_school': graduated_school,
                    'summary': summary,
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.error.returnCode == 0) {
                        alert('修改案例成功！');
                        window.location.reload();
                    }else {
                        alert('修改案例失败！');
                    }
                },
                error: function (data) {
                    alert('修改案例异常！');
                }
            });
        }
    }
</script>
{include "layout/footer.tpl"}
{include "layout/header.tpl" }
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/jquery.dataTables.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/datatables-1.10.7/dataTables.bootstrap.js"></script>
<script src="/static/js/select2/select2.js"></script>
<link href="/static/js/select2/select2.css" rel="stylesheet">
<div class="col-sm-12">
    <section class="panel">
        <header class="panel-heading">
            在办客户管理
            <a type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_user_portal">新增</a>
        </header>
        <div class="panel-body">
                <table cellspacing="0"  id="member_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>申请人姓名</th>
                        <th>合同ID</th>
                        <th>联系方式</th>
                        <th>申请国家</th>
                        <th>申请项目</th>
                        <th>服务类型</th>
                        <th>出国年份</th>
                        <th>签约业务线</th>
                        <th>微信号</th>
                        <th>绑定微信</th>
                        <th>选校状态</th>
                        <th>申请状态</th>
                        <th>签证状态</th>
                        <th>结案状态</th>
                        <th>结案类型</th>
                        <th>沟通跟进</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $customer_list as $one}
                        <tr>
                            <td>{$one['name']}</td>
                            <td>{$one['contract_id']}</td>
                            <td>{$one['phone']}</td>
                            <td>{$one['apply_country']}</td>
                            <td>{$one['apply_project']}</td>
                            <td>{$one['service_type']}</td>
                            <td>{$one['go_abroad_year']}</td>
                            <td>{$one['line_business']}</td>
                            <td>{$one['wechat']}</td>
                            <td>{$one['bind_wechat']}</td>
                            <td>{$one['select_check']}</td>
                            <td>{$one['apply_status']}</td>
                            <td>{$one['visa_status']}</td>
                            <td>{$one['close_case_status']}</td>
                            <td>{$one['close_case_type']}</td>
                            <td>{$one['communication']}
                            <td>
                                <a type="button" class="btn btn-sm btn-danger" href="/page/customer/info?id={$one['id']}">查看</a>
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
                    添加客户
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请人姓名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_name">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">合同ID：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_contract_id">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">联系方式：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_phone">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请国家：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_apply_country">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请项目：</label>
                        <select id="add_apply_project" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">硕士</option>
                            <option value="2">硕士预科</option>
                            <option value="3">单签证</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">服务类型：</label>
                        <select id="add_service_type" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">全程服务</option>
                            <option value="2">签证</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">出国年份：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_go_abroad_year">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">签约业务线：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_line_business">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">微信号：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="add_wechat">
                        </div>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="create_customer()">
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

    function create_customer() {
        var name = $('#add_name').val().trim();
        var contract_id = $('#add_contract_id').val().trim();
        var phone = $('#add_phone').val().trim();
        var apply_country = $('#add_apply_country').val().trim();
        var apply_project = $('#add_apply_project').val().trim();
        var service_type = $('#add_service_type').val().trim();
        var go_abroad_year = $('#add_go_abroad_year').val().trim();
        var line_business = $('#add_line_business').val().trim();
        var wechat = $('#add_wechat').val().trim();
        if(confirm('确定要新增此客户吗?')) {
            $.ajax({
                url: '/api/customer/add',
                type: "POST",
                data: {
                    'name': name,
                    'contract_id': contract_id,
                    'phone': phone,
                    'apply_country': apply_country,
                    'apply_project': apply_project,
                    'service_type': service_type,
                    'go_abroad_year': go_abroad_year,
                    'line_business': line_business,
                    'wechat': wechat,
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
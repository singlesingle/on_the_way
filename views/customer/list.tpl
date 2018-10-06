{include "layout/header.tpl" }
<script src="/static/js/select2/select2.js"></script>
<link href="/static/js/select2/select2.css" rel="stylesheet">
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/moment.min.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/daterangepicker.js"></script>
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/daterangepicker.css" rel="stylesheet">
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/colresizable-1.5/colResizable-1.5.min.js"></script>
<div class="col-sm-12">
    <section class="panel">
        <header class="panel-heading">
            <laber style="font-size:large">在办客户管理</laber>
            <a type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#add_user_portal">新增</a>

            <div class="form-inline row" style="margin-bottom: 10px; margin-top: 20px">
                    <div class="form-group col-md-2">
                        <div >申请国家</div>
                        <select id="search_apply_country" class="form-control" style="width:200px;">
                            <option value=""></option>
                            <option value="1">英国</option>
                            <option value="2">加拿大</option>
                            <option value="3">澳大利亚</option>
                            <option value="4">欧洲</option>
                            <option value="5">新西兰</option>
                            <option value="6">爱尔兰</option>
                            <option value="7">香港</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <div >申请项目</div>
                        <select id="search_apply_project" class="form-control" style="width:200px;">
                            <option value=""></option>
                            <option value="1">初中</option>
                            <option value="2">高中</option>
                            <option value="3">本科</option>
                            <option value="4">硕士</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <div >服务类型</div>
                        <select id="search_service_type" class="form-control" style="width:200px;">
                            <option value=""></option>
                            <option value="1">单文书</option>
                            <option value="2">全程服务</option>
                            <option value="3">单申请</option>
                            <option value="4">签证</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <div >出国年份</div>
                        <select id="search_go_abroad_year" class="form-control" style="width:200px;">
                            <option value=""></option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <div >申请状态</div>
                        <select id="search_apply_status" class="form-control" style="width:200px;">
                            <option value=""></option>
                            <option value="0">未开始</option>
                            <option value="1">申请中</option>
                            <option value="2">已完成</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <div >签证状态</div>
                        <select id="search_visa_status" class="form-control" style="width:200px;">
                            <option value=""></option>
                            <option value="0">待申请</option>
                            <option value="1">签证递交</option>
                            <option value="2">获签</option>
                            <option value="3">拒签</option>
                        </select>
                    </div>
            </div>
            <div class="form-inline row" style="margin-bottom: 10px">
                <div class="form-group col-md-2">
                    <div >结案状态</div>
                    <select id="search_close_case_status" class="form-control" style="width:200px;">
                        <option value=""></option>
                        <option value="1">未结案</option>
                        <option value="2">已结案</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 text-center" style="margin-bottom: 20px">
                <button class="btn btn-danger" onclick="data()">查询</button>
            </div>
        </header>
        <div class="panel-body">
                <table cellspacing="0"  id="customer_list" class="table table-bordered table-striped">
                    <thead>
                    <tr role="row">
                        <th>申请人姓名</th>
                        <th>合同ID</th>
                        <th>联系方式</th>
                        <th>申请国家</th>
                        <th>申请项目</th>
                        <th>服务类型</th>
                        <th>出国年份</th>
                        <th>微信昵称</th>
                        <th>申请状态</th>
                        <th>签证状态</th>
                        <th>结案状态</th>
                        {*<th>沟通跟进</th>*}
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
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
                        <select id="add_apply_country" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">英国</option>
                            <option value="2">加拿大</option>
                            <option value="3">澳大利亚</option>
                            <option value="4">欧洲</option>
                            <option value="5">新西兰</option>
                            <option value="6">爱尔兰</option>
                            <option value="7">香港</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">申请项目：</label>
                        <select id="add_apply_project" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">初中</option>
                            <option value="2">高中</option>
                            <option value="3">本科</option>
                            <option value="4">硕士</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">服务类型：</label>
                        <select id="add_service_type" class="col-sm-6">
                            <option value=""></option>
                            <option value="1">单文书</option>
                            <option value="2">全程服务</option>
                            <option value="3">单申请</option>
                            <option value="4">签证</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">出国年份：</label>
                        <select id="add_go_abroad_year" class="col-sm-6">
                            <option value=""></option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                        <span class="text-danger mt5 fl">*</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">微信昵称：</label>
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
    $(document).ready(
        data
    );

    function data() {
        $('#customer_list').DataTable({
            "iDisplayLength": 25,
            "sPaginationType": "full_numbers",
            'language': {
                'emptyTable': '没有数据',
                'loadingRecords': '加载中...',
                'processing': '查询中...',
                'search': '检索:',
                'lengthMenu': '每页 _MENU_ 条',
                'zeroRecords': '没有数据',
                'paginate': {
                    'first':      '第一页',
                    'last':       '最后一页',
                    'next':       '下一页',
                    'previous':   '上一页'
                },
                'info': '第 _PAGE_ 页 / 总 _PAGES_ 页 共_MAX_条',
                'infoEmpty': '没有数据',
                'infoFiltered': '(过滤总件数 _MAX_ 条)'
            },
            "searching":false,
            "ordering":false,
            "bPaginite": true,
            "bInfo": true,
            "bSort": false,
            "processing": false,
            "bServerSide": true,
            "destroy": true,
            "sAjaxSource": "/api/customer/searchlist",//这个是请求的地址
            "fnServerData": retrieveData,// 获取数据的处理函数

        });
    }

    function retrieveData(url, aoData, fnCallback) {
        var apply_country = $("#search_apply_country").val();
        var apply_project = $("#search_apply_project").val();
        var service_type = $("#search_service_type").val();
        var go_abroad_year = $("#search_go_abroad_year").val();
        var apply_status = $("#search_apply_status").val();
        var visa_status = $("#search_visa_status").val();
        var close_case_status = $("#search_close_case_status").val();
        $.ajax({
            url: url,//这个就是请求地址对应sAjaxSource
            data : {
                "aoData":JSON.stringify(aoData),
                'apply_country':apply_country,
                'apply_project':apply_project,
                'service_type':service_type,
                'go_abroad_year':go_abroad_year,
                'apply_status':apply_status,
                'visa_status':visa_status,
                'close_case_status':close_case_status,
                'page':'all'
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (result) {
                fnCallback(result);//把返回的数据传给这个方法就可以了,datatable会自动绑定数据的
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                alert("status:"+XMLHttpRequest.status+",readyState:"+XMLHttpRequest.readyState+",textStatus:"+textStatus);

            }
        });
    }

    function create_customer() {
        var name = $('#add_name').val().trim();
        var contract_id = $('#add_contract_id').val().trim();
        var phone = $('#add_phone').val().trim();
        var apply_country = $('#add_apply_country').val().trim();
        var apply_project = $('#add_apply_project').val().trim();
        var service_type = $('#add_service_type').val().trim();
        var go_abroad_year = $('#add_go_abroad_year').val().trim();
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
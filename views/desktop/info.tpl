{include "layout/header.tpl" }
<style>
.panel {
     background: #f0ffde;
 }
.panel-heading {
    background: #f0ffde;
}
.row {
    margin-top: 0px;
    margin-bottom: 10px;
}
</style>
<link href="/static/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/static/js/advanced-datatable/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/static/css/jquery.datetimepicker.css"/>
<script type="text/javascript" src="/static/js/jquery.datetimepicker.full.min.js"></script>
<script src="/static/js/select2/select2.js"></script>
<script src="/static/js/advanced-datatable/js/jquery.dataTables.min.js" type="text/javascript"></script>
<section class="col-sm-12">
    <div class="col-sm-8 ">
        <div class="row">
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading">
                        <span class="panel-title">今日应回访</span>
                    </header>
                    <div class="panel-body">
                        <div>
                            <div id="dsmscount" style="text-align: center; margin:0 auto; font-size: 20px; font-weight: bold;"><u>0</u></div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading">
                        <span class="panel-title">用户评价</span>
                    </header>
                    <div class="panel-body">
                        <div>
                            <div id="dsmscount" style="text-align: center; margin:0 auto; color: orange">您还没有评价</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading">
                    <span class="panel-title">我的在办客户</span>&nbsp;<span style="color: #3580b5;font-size: 20px; font-weight: bold;">8</span>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">已签约<u style="color: #3580b5;font-size: 16px;">8</u></div>
                        <div class="col-sm-4">选校中<u style="color: #3580b5;font-size: 16px;">1</u></div>
                        <div class="col-sm-4">申请中<u style="color: #3580b5;font-size: 16px;">4</u></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">已获offer<u style="color: #3580b5;font-size: 16px;">5</u></div>
                        <div class="col-sm-4">已办签证<u style="color: #3580b5;font-size: 16px;">0</u></div>
                        <div class="col-sm-4">已结案<u style="color: #3580b5;font-size: 16px;">14</u></div>
                    </div>
                </div>
            </section>
        </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <section class="panel">
                <header class="panel-heading">
                    <span class="panel-title">常用工具</span>
                </header>
                <div class="panel-body">
                    <div>
                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#gpa_page" >GPA计算</a>
                        <a class="btn btn-success btn-sm" href="/page/user/info" >个人信息设置</a>
                    </div>
                </div>
            </section>
        </div>
        <div class="row">
            <section class="panel">
                <div class="panel-heading">
                    <table cellspacing="0"  id="message_list" class="table table-bordered table-striped">
                        <thead>
                            <tr role="row">
                                <th>快捷通知</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>

<div class="modal fade" id="gpa_page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    GPA计算
                </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tbody> <tr> <td width="211" valign="top">百分制<br></td> <td width="211" valign="top">五等级制</td> <td width="211" valign="top"><div class="para">学分绩点</div> </td> </tr> <tr><td width="211" valign="top">100-95</td><td width="211" valign="top">A+</td><td width="211" valign="top">4.3</td></tr> <tr><td width="211" valign="top">94-90</td><td width="211" valign="top">A</td><td width="211" valign="top">4</td></tr> <tr><td width="211" valign="top">89-85</td><td width="211" valign="top">A-</td><td width="211" valign="top">3.7</td></tr> <tr><td width="211" valign="top">84-82</td><td width="211" valign="top">B+</td><td width="211" valign="top">3.3</td></tr> <tr><td width="211" valign="top">81-78</td><td width="211" valign="top">B</td><td width="211" valign="top">3</td></tr> <tr><td width="211" valign="top">77-75</td><td width="211" valign="top">B-</td><td width="211" valign="top">2.7</td></tr> <tr><td width="211" valign="top">74-72</td><td width="211" valign="top">C+</td><td width="211" valign="top">2.3</td></tr> <tr><td width="211" valign="top">71-68</td><td width="211" valign="top">C</td><td width="211" valign="top">2</td></tr> <tr><td width="211" valign="top">67-65</td><td width="211" valign="top">C-</td><td width="211" valign="top">1.7</td></tr> <tr><td width="211" valign="top">64</td><td width="211" valign="top">D+</td><td width="211" valign="top">1.5</td></tr> <tr><td width="211" valign="top">63-61</td><td width="211" valign="top">D</td><td width="211" valign="top">1.3</td></tr> <tr><td width="211" valign="top">60</td><td width="211" valign="top">D-</td><td width="211" valign="top">1</td></tr> <tr><td valign="top" colspan="1" rowspan="1">&lt;60</td><td valign="top" colspan="1" rowspan="1">F</td><td valign="top" colspan="1" rowspan="1">0</td></tr> </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
    $(document).ready(
        data
    );

    function data() {
        $('#message_list').DataTable({
            // "iDisplayLength": 25,
            "sPaginationType": "full_numbers",
            'language': {
                'emptyTable': '没有数据',
                'loadingRecords': '加载中...',
                'processing': '查询中...',
                'search': '检索:',
                'lengthMenu': '',
                'zeroRecords': '没有数据',
                'paginate': {
                    'first':     '',
                    'last':       '',
                    'next':       '下一页',
                    'previous':   '上一页'
                },
                // 'info': '第 _PAGE_ 页 / 总 _PAGES_ 页 共_MAX_条',
                'infoEmpty': '没有数据',
                'infoFiltered': '(过滤总件数 _MAX_ 条)',
                "info": ''
            },
            "searching":false,
            "ordering":false,
            "bPaginite": true,
            "bInfo": true,
            "bSort": false,
            "processing": false,
            "bServerSide": true,
            "destroy": true,
            "sAjaxSource": "/api/message/mylist",//这个是请求的地址
            "fnServerData": retrieveData,// 获取数据的处理函数

        });
    }

    function retrieveData(url, aoData, fnCallback) {
        $.ajax({
            url: url,//这个就是请求地址对应sAjaxSource
            data : {
                "aoData":JSON.stringify(aoData),
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
</script>

{include "layout/footer.tpl"}

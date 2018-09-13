{include file="layout/header.tpl" }
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/moment.min.js"></script>
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/daterangepicker.js"></script>
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="https://magicbox.bkclouds.cc/static_api/v3/assets/daterangepicker-2.0.5/daterangepicker.css" rel="stylesheet">
<script src="https://magicbox.bkclouds.cc/static_api/v3/assets/colresizable-1.5/colResizable-1.5.min.js"></script>
<section class="content-header">
<h3>操作审计</h3>
</section>

<section class="panel">
    <header class="panel-heading">
        查询条件
    </header>
    <div class="panel-body">
        <form class="form-inline">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">用户名</label>
                <input type="text" class="form-control" style="width:300px;" name="nameinput" id="nameinput" placeholder="请输入用户名" value="{$username}">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">来源IP</label>
                <input type="text" class="form-control" style="width:300px;" id="ipinput" name="ipinput" placeholder="请输入来源IP" value="{$fromip}">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">操作对象</label>
                <select id="caozuoduixiang" class="form-control" name="duixianginput" style="width:300px;">
                <option value="">>全部<</option>
                {foreach from=$opservice item=serv}
                <option value="{$serv}" {if $duixianginput == $serv}selected='selected'{/if}>{$serv}</option>
                {/foreach}
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">操作类型</label>
                <!-- select2 下拉选项可多选 start -->
                <select id="caozuoleixing" class="form-control" name="caozuoinput" style="width:300px;">
                <option value="">>全部<</option>
                <option value="新增" {if $caozuoinput == '新增'}selected='selected'{/if}>新增</option>
                <option value="修改" {if $caozuoinput == '修改'}selected='selected'{/if}>修改</option>
                <option value="删除" {if $caozuoinput == '删除'}selected='selected'{/if}>删除</option>
                </select>
                <!-- select2 下拉选项可多选 end -->
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">执行结果</label>
                <select id="zhixingjieguo" class="form-control" name="jieguoinput" style="width:300px;">
                <option value="">>全部<</option>
                <option value="1" {if $jieguoinput == '1'}selected='selected'{/if}>成功</option>
                <option value="0" {if $jieguoinput == '0'}selected='selected'{/if}>失败</option>
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">开始时间</label>
                <input type="text" class="form-control" id="begintime" name="begintime" style="width:300px;" placeholder="请输入开始时间">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">结束时间</label>
                <input type="text" class="form-control" id="endtime" style="width:300px;" name="endtime"  placeholder="请输入结束时间">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="inputCount">关键字</label>
                <input type="text" class="form-control" id="keyinput" style="width:300px;" name="logkeywd" placeholder="请输入参数关键字" value="{$logkeywd}">
            </div>
        </div>
        <div class="col-xs-12 text-center">
        <input type="button" class="btn btn-default" onclick="self.location='/page/actionlog/index';" value="重置">
        <button class="btn btn-primary" id="log_query_submit">查询</button>
        </div>
        </form>
    </div>
</section>

<section class="panel">
    <div class="panel-body">
    <table id="logtable" class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 10%;">用户名</th>
            <th style="width: 10%;">操作IP</th>
            <th style="width: 10%;">操作类型</th>
            <th style="width: 10%;">操作对象</th>
            <th style="width: 10%;">操作结果</th>
            <th style="width: 10%;">操作时间</th>
            <th style="width: 5%;">耗时</th>
            <th style="width: 15%;">操作URL</th>
            <th style="width: 20%;">请求参数</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$loglist item=logobj}
            <tr>
                <td>{$logobj.username}</td>
                <td>{$logobj.fromip}</td>
                <td>{$logobj.optype}</td>
                <td>{$logobj.opservice}</td>
                <td>{if $logobj.opresult == 1}成功{else}失败{/if}</td>
                <td>{$logobj.optime}</td>
                <td>{$logobj.exectime|string_format:"%.2f"}</td>
                <td>{$logobj.actionurl}</td>
                <td>{$logobj.oplog}</td>
            </tr>
        {/foreach}
        </tbody>
    </div>
</section>

<script type="text/javascript">
// 选择单个日期
$('#begintime').daterangepicker({
locale : {
format : 'YYYY-MM-DD HH:mm:ss'
},
startDate: '{$starttime}',
autoApply: true,//选择日期后自动设置值
singleDatePicker : true,//单选选择一个日期
timePicker: true,//支持时间选择
timePicker24Hour: true,//开启24小时时间制
timePickerIncrement : 5, //分钟间隔
timePickerSeconds: true //开启分钟选择

});
$('#endtime').daterangepicker({
locale : {
format : 'YYYY-MM-DD HH:mm:ss'
},
startDate: '{$endtime}',
autoApply: true,//选择日期后自动设置值
singleDatePicker : true,//单选选择一个日期
timePicker: true,//支持时间选择
timePicker24Hour: true,//开启24小时时间制
timePickerIncrement : 5, //分钟间隔
timePickerSeconds: true //开启分钟选择

});
</script>
{include file="layout/footer.tpl" }

<!DOCTYPE html>
<html lang="ch">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="ThemeBucket">
<link rel="shortcut icon" type="image/x-icon" href="/static/img/logo.png"/>
<title>在途客户管理系统</title>
<!--Core CSS -->
<link href="/static/bs3/css/bootstrap.min.css" rel="stylesheet">
<link href="/static/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
<link href="/static/js/advanced-datatable/css/jquery.dataTables.css" rel="stylesheet">
<link href="/static/css/bootstrap-reset.css" rel="stylesheet">
<link href="/static/css/bootstrap-switch.css" rel="stylesheet">
<link href="/static/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="/static/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
<link href="/static/css/clndr.css" rel="stylesheet">
<!--clock css-->
<link href="/static/js/css3clock/css/style.css" rel="stylesheet">
<!--Morris Chart CSS -->
<link rel="stylesheet" href="/static/js/morris-chart/morris.css">
<!-- Custom styles for this template -->
<link href="/static/css/style.css" rel="stylesheet">
<link href="/static/css/style-responsive.css" rel="stylesheet"/>
<script src="/static/js/jquery.js"></script>
</head>
<body>
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">

            <a href="/page/desktop/info" class="logo">
                在途客户管理系统
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>

        <div class="nav notify-row" id="top_menu">
            <!--  notification start -->
            <ul class="nav top-menu">
                <!-- notification dropdown start-->
                <li id="header_notification_bar" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                        <i class="fa fa-bell-o"></i>
                        <span class="badge bg-important">{count($notice)}</span>
                    </a>
                    <ul class="dropdown-menu extended notification">
                        <li>
                            <p>消息通知</p>
                        </li>
                        {foreach $notice as $message}
                        <li>
                            <div class="alert alert-info clearfix">
                                {*<span class="alert-icon"><i class="fa fa-bolt"></i></span>*}
                                <div class="noti-info">
                                    <a data-toggle="modal" data-target="#notice_message" onclick="readMessage({$message['id']})">{$message['title']}</a>
                                </div>
                            </div>
                        </li>
                        {/foreach}
                    </ul>
                </li>
                <!-- notification dropdown end -->
            </ul>
            <!--  notification end -->
        </div>

        <!--logo end-->
        <div class="top-nav clearfix">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <!-- user login dropdown start-->
                <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="{$name}" src="/static/img/avatar1_small.jpg">
                    <span class="username">{$name}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="/page/user/info"><i class="fa fa-suitcase"></i>个人信息</a></li>
                    <li><a href="/page/user/login"><i class="fa fa-key"></i> 退出登陆</a></li>
                </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
            <!--search & user info end-->
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse">
            <!-- sidebar menu start-->
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion">
                    <li class="sub-menu">
                        <a href="javascript:;" class="{if $page_topo eq "desktop"}active{/if}">
                            <i class="fa fa-home"></i>
                            <span>首页</span>
                        </a>
                        <ul class="sub">
                            <li {if $page_topo eq "desktop"}class="active"{/if}><a href="/page/desktop/info">我的办公桌</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="{if $page_topo eq "customer_admin"}active{/if}">
                            <i class="fa fa-users"></i>
                            <span>CRM</span>
                        </a>
                        <ul class="sub">
                            <li {if $page_topo eq "customer_admin"}class="active"{/if}><a href="/page/customer/list">在办客户管理</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="{if $page_topo eq "case_admin"}active{/if}">
                            <i class="fa fa-fire"></i>
                            <span>案例库</span>
                        </a>
                        <ul class="sub">
                            <li {if $active_page eq "inner"}class="active"{/if}><a href="/page/case/inner">内部案例库</a></li>
                            <li {if $active_page eq "my"}class="active"{/if}><a href="/page/case/my">我的案例</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="{if $page_topo eq "document_admin"}active{/if}">
                            <i class="fa fa-file-text"></i>
                            <span>文书库</span>
                        </a>
                        <ul class="sub">
                            <li {if $active_page eq "document_list"}class="active"{/if}><a href="/page/document/list">文书范例</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="{if $page_topo eq "admin"}active{/if}">
                            <i class="fa fa-sitemap"></i>
                            <span>管理</span>
                        </a>
                        <ul class="sub">
                            <li {if $active_page eq "user_admin"}class="active"{/if}><a href="/page/user/list">用户</a></li>
                        </ul>
                        <ul class="sub">
                            <li {if $active_page eq "message_admin"}class="active"{/if}><a href="/page/message/list">消息</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <div class="modal fade" id="notice_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">
                        <p id="notice_title"></p>
                        <p id="notice_create_time"></p>
                    </h4>
                </div>
                <div class="modal-body">
                    <p id="notice_content"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
    <section class="wrapper">
        <script>
            function readMessage(id) {
                $.ajax({
                    url: '/api/message/info',//这个就是请求地址对应sAjaxSource
                    data : {
                        "message_id": id
                    },
                    type: 'POST',
                    dataType: "json",
                    async: false,
                    success: function (data) {
                        if (data.error.returnCode == 0) {
                            $("#notice_title").html(data.data.title);
                            $("#notice_create_time").html(data.data.create_time);
                            $("#notice_content").html(data.data.content);
                        }else {
                        }
                    },
                    error: function (data) {
                        alert('查询异常！');
                    }
                });
            }
        </script>

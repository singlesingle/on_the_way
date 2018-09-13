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
</head>
<body>
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">

            <a href="/page/welcome/index.html" class="logo">
                在途客户管理系统
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!--logo end-->
        <div class="top-nav clearfix">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <!-- user login dropdown start-->
                <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="{$loginuser}" src="{if $loginphoto eq ".jpg.29x29.jpg"}/static/img/avatar1_small.jpg{else}{$loginphoto}{/if}">
                    <span class="username">{$logincnname}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="{$uic_addr}/me/profile"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="{$uic_addr}/me/logout"><i class="fa fa-key"></i> Log Out</a></li>
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
                    <li>
                        <a {if $active_page eq "desktop"}class="active"{/if} href="/page/desktop/info">
                            <i class="fa fa-bar-chart-o"></i>
                            <span>我的办公桌</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="/page/cron/project" class="{if $page_topo eq "cron"}active{/if}">
                            <i class="fa fa-eye"></i>
                            <span>在办客户管理</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="active">
                            <i class="fa fa-fire"></i>
                            <span>案例库</span>
                        </a>
                        <ul class="sub">
                            <li {if $active_page eq "monitorlist"}class="active"{/if}><a href="/page/monitorportal/monitorlist">内部案例库</a></li>
                            <li {if $active_page eq "monitorlist"}class="active"{/if}><a href="/page/monitorportal/monitorlist">我的案例</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="active">
                            <i class="fa fa-fire"></i>
                            <span>文书库</span>
                        </a>
                        <ul class="sub">
                            <li {if $active_page eq "monitorlist"}class="active"{/if}><a href="/page/monitorportal/monitorlist">文书范例</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="/page/user/list" class="{if $page_topo eq "user_admin"}active{/if}">
                            <i class="fa fa-eye"></i>
                            <span>用户管理</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
    <section class="wrapper">

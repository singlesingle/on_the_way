<?php
return [
    
    //相关页面url
    '/' => 'page/desktop/info',
    'page/desktop/info' => 'page/desktop/info',
    'page/user/list' => 'page/user/list',
    'page/user/login' => 'page/user/login',
    'page/user/info' => 'page/user/info',
    'page/case/my' => 'page/case/my',
    'page/case/inner' => 'page/case/inner',
    'page/case/info' => 'page/case/info',
    'page/customer/list' => 'page/customer/list',
    'page/customer/info' => 'page/customer/info',
    'page/document/list' => 'page/document/list',
    'page/message/list' => 'page/message/list',
    /////// page url rules end

    /////// api url rules begin
    'api/wx/reply' => 'api/wx/reply',
    'api/user/login' => 'api/user/login',
    'api/user/adduser' => 'api/user/adduser',
    'api/user/deleteuser' => 'api/user/deleteuser',
    'api/user/enableuser' => 'api/user/enableuser',
    'api/user/disuser' => 'api/user/disuser',
    'api/user/transfer' => 'api/user/transfer',
    'api/user/manager' => 'api/user/manager',
    'api/user/update' => 'api/user/update',
    'api/user/pwd' => 'api/user/pwd',
    'api/case/add' => 'api/case/add',
    'api/case/update' => 'api/case/update',
    'api/customer/add' => 'api/customer/add',
    'api/customer/update' => 'api/customer/update',
    'api/customer/list' => 'api/customer/list',
    'api/customer/searchlist' => 'api/customer/searchlist',
    'api/customer/savebasicinfo' => 'api/customer/savebasicinfo',
    'api/customer/addmaterial' => 'api/customer/addmaterial',
    'api/customer/saveeducation' => 'api/customer/saveeducation',
    'api/document/add' => 'api/document/add',
    'api/document/upload' => 'api/document/upload',
    'api/document/download' => 'api/document/download',
    'api/document/delete' => 'api/document/delete',
    'api/message/add' => 'api/message/add',
    'api/message/release' => 'api/message/release',
    'api/message/delete' => 'api/message/delete',
    'api/message/mylist' => 'api/message/mylist',
    'api/message/info' => 'api/message/info',
    'api/school/add' => 'api/school/add',
    /////// api url rules end

    /////// cron url rules tart
    'api/customer/status' => 'api/customer/status',
    /////// cron url rules end

    '/403'  => 'page/error/error403',
    '/404'  => 'page/error/error404',
    '/500'  => 'page/error/error500'
];

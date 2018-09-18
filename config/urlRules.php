<?php
return [
    
    //相关页面url
    '/' => 'page/desktop/info',
    'page/desktop/info' => 'page/desktop/info',
    'page/user/list' => 'page/user/list',
    'page/user/login' => 'page/user/login',
    'page/case/my' => 'page/case/my',
    'page/case/inner' => 'page/case/inner',
    /////// page url rules end

    /////// api url rules begin
    'api/user/login' => 'api/user/login',
    'api/user/adduser' => 'api/user/adduser',
    'api/user/deleteuser' => 'api/user/deleteuser',
    'api/user/disuser' => 'api/user/disuser',
    'api/user/transfer' => 'api/user/transfer',

    /////// api url rules end

    '/403'  => 'page/error/error403',
    '/404'  => 'page/error/error404',
    '/500'  => 'page/error/error500'
];

<?php
//相关常量和路径定义
define('APP_PATH', realpath(dirname(__FILE__) . '/../'));
define('APP_PROJECT_NAME', 'on_the_way');
define('APP_VERSION', '1.0.0');
define('APP_CONFIG_PATH', APP_PATH . '/config');

//从配置文件读取配置
$environment = "dev";
$params = require(__DIR__ . '/' . $environment . '_params.php');
$db = require(__DIR__ . '/' . $environment . '_db.php');
$params = array_merge($params, $db);

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'runtimePath' => $cacheDir,
    'components' => [
        'redis' => $params['redis'],
        'db' => $params['mysql'],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

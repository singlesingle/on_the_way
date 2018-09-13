<?php

return [
    'mysql' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1:3306;dbname=on_the_way',
        'username' => 'root',
        'password' => '123qwe',
        'charset' => 'utf8',
    ],
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port' => 11056,
        'database' => 0,
    ],
];

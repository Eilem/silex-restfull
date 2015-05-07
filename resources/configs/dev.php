<?php
require __DIR__ . '/prod.php';
$app['debug'] = true;
$app['log.level'] = Monolog\Logger::DEBUG;
$app['db'] = array(
    'db.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'database_name',
        'user'      => 'database_user',
        'password'  => 'database_password',
        'charset'   => 'utf8'
    )
);
<?php
$app['log.level'] = Monolog\Logger::ERROR;
$app['log.file'] = ROOT_PATH . "/storage/logs/";
$app['api.version'] = "v1";
$app['api.endpoint'] = "/api";
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
$app["path_class"] = ROOT."/vendor/MyProject/src";// Load Business with Doctrine
$app["path_controllers"] = ROOT."/src/App/Controllers/";
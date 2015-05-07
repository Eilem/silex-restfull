<?php
/*
| -------------------------------------------------------------------
| Constants
| -------------------------------------------------------------------
*/
defined('ROOT_PATH')
|| define('ROOT_PATH', realpath(dirname(__DIR__)));

defined('RESOURCES_PATH')
|| define('RESOURCES_PATH', ROOT_PATH.'/resources');


/*
| -------------------------------------------------------------------
| Autoload...
| -------------------------------------------------------------------
*/
require_once ROOT_PATH."/vendor/autoload.php";

$app = new Silex\Application();

require RESOURCES_PATH."/configs/prod.php";
require RESOURCES_PATH."/configs/dev.php";
require ROOT_PATH."/src/app.php";

/*
| -------------------------------------------------------------------
| Run App
| -------------------------------------------------------------------
*/
$app['http_cache']->run();

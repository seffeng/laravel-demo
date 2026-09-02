<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/**
 * APP NAME
 * @var string
 */
define('APP_NAME', 'api');

/**
 * 当前目录
 * @var string
 */
define('THIS_PATH', preg_replace_callback('/[\/\\\\]+/', function() { return '/'; }, __DIR__));

/**
 * 程序根目录
 * @var string
 */
define('ROOT_PATH', dirname(dirname(THIS_PATH)));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = ROOT_PATH . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require ROOT_PATH . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once ROOT_PATH . '/bootstrap/app.php';

$app->handleRequest(Request::capture());

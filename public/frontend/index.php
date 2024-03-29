<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/**
 * APP NAME
 * @var string
 */
define('APP_NAME', 'frontend');

/**
 * 当前目录
 * @var string
 */
define('THIS_PATH', preg_replace_callback('/[\/\\\\]+/', function($match){ return '/'; }, dirname(__FILE__)));

/**
 * 程序根目录
 * @var string
 */
define('ROOT_PATH', dirname(dirname(THIS_PATH)));

/*
 |--------------------------------------------------------------------------
 | Register The Auto Loader
 |--------------------------------------------------------------------------
 |
 | Composer provides a convenient, automatically generated class loader for
 | our application. We just need to utilize it! We'll simply require it
 | into the script here so that we don't have to worry about manual
 | loading any of our classes later on. It feels great to relax.
 |
 */

require ROOT_PATH .'/vendor/autoload.php';

/*
 |--------------------------------------------------------------------------
 | Turn On The Lights
 |--------------------------------------------------------------------------
 |
 | We need to illuminate PHP development, so let us turn on the lights.
 | This bootstraps the framework and gets it ready for use, then it
 | will load up this application so that we can run it and send
 | the responses back to the browser and delight our users.
 |
 */

$app = require_once ROOT_PATH .'/bootstrap/app.php';

/*
 |--------------------------------------------------------------------------
 | Run The Application
 |--------------------------------------------------------------------------
 |
 | Once we have the application, we can handle the incoming request
 | through the kernel, and send the associated response back to
 | the client's browser allowing them to enjoy the creative
 | and wonderful application we have prepared for them.
 |
 */

/**
 * @var Illuminate\Contracts\Http\Kernel $kernel
 */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

/**
 * @var \Symfony\Component\HttpFoundation\Response $response
 */
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

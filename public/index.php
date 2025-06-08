<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Temporary debug: Check APP_KEY
error_log('Attempting to read APP_KEY from env: ' . (env('APP_KEY') ? 'FOUND' : 'NOT FOUND'));
if (env('APP_KEY')) {
    error_log('APP_KEY value (first 10 chars): ' . substr(env('APP_KEY'), 0, 10));
    error_log('APP_KEY full value (for verification, remove after test): ' . env('APP_KEY')); // Be cautious with logging full keys
} else {
    error_log('APP_KEY is not found using env(). Trying getenv().');
    error_log('Attempting to read APP_KEY from getenv: ' . (getenv('APP_KEY') ? 'FOUND' : 'NOT FOUND'));
    if (getenv('APP_KEY')) {
         error_log('APP_KEY value via getenv (first 10 chars): ' . substr(getenv('APP_KEY'), 0, 10));
         error_log('APP_KEY full value via getenv (for verification, remove after test): ' . getenv('APP_KEY'));
    }
}
// End Temporary debug

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);

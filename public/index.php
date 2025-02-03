<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

$request = Request::capture();

$isRest = $request && str_starts_with($request->getRequestUri(), '/rest-api');

/** @var \Illuminate\Foundation\Application $app */
$app = $isRest
    ? require_once __DIR__.'/../bootstrap/rest-api.php'
    : require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest($request);

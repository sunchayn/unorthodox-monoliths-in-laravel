<?php

use App\Http\RestApi\RestApiApplication;
use Illuminate\Foundation\Configuration\Middleware;

$app = RestApiApplication::configure(basePath: dirname(__DIR__))
    ->withRouting()
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('rest-api', [

        ]);
    })
    ->create();

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\RestApi\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\RestApiHandler::class
);

return $app;

<?php

use App\Http\Monolith\MonolithApplication;

$app = MonolithApplication::configure(basePath: dirname(__DIR__))
    ->withExceptions()
    ->withCommands([__DIR__.'/../routes/console.php'])
    ->create();

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    \App\Http\Monolith\Kernel::class,
);

// In case you want a custom exception handler to properly report and render exception per application
// Such as: Web, CMS, Webhook, etc.
// Make sure to remove ->withExceptions()
// $app->singleton(
//    Illuminate\Contracts\Debug\ExceptionHandler::class,
//    // ...
// );

return $app;

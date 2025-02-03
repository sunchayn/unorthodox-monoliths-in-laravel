<?php

namespace App\Http\Monolith;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as KernelBase;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends KernelBase
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middlewares are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        ValidatePostSize::class,
        TrimStrings::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        PreventRequestsDuringMaintenance::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,

    ];

    /**
     * The application's route middleware.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            SubstituteBindings::class,
            AuthenticateSession::class,
        ],
    ];
}

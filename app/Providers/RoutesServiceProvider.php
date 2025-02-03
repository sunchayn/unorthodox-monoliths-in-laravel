<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RoutesServiceProvider extends BaseRouteServiceProvider
{
    public function map(): void
    {
        $this->mapWebRoutes();
        $this->mapRestApiRoutes();
    }

    private function mapWebRoutes(): void
    {
        Route::group(
            [
                'prefix' => 'web',
                'middleware' => ['web'],
            ],
            function () {
                require base_path('routes/web.php');
            },
        );
    }

    private function mapRestApiRoutes(): void
    {
        Route::group(
            [
                'prefix' => 'rest-api',
                'middleware' => ['rest-api'],
            ],
            function () {
                require base_path('routes/rest-api.php');
            },
        );
    }
}

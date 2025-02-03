<?php

namespace App\Http\RestApi;

use Illuminate\Foundation\Application as BaseApplication;

class RestApiApplication extends BaseApplication
{
    public function registerConfiguredProviders(): void
    {
        parent::registerConfiguredProviders();

        $providers = require base_path('bootstrap/contextual-providers/rest-api.php');

        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }
}

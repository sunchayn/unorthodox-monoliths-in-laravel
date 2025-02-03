<?php

namespace App\Http\Monolith;

use Illuminate\Foundation\Application as BaseApplication;

class MonolithApplication extends BaseApplication
{
    public function registerConfiguredProviders(): void
    {
        parent::registerConfiguredProviders();

        $providers = require base_path('bootstrap/contextual-providers/monolith.php');

        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }
}

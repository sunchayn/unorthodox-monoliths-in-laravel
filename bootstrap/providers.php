<?php

use App\Providers as Providers;

return [
    /*
     * Core Services Providers.
     * These are the providers used by all applications.
     * Don't register anything freely here. Check `app.contextual_providers` first for contextual providers.
     */

    Providers\RoutesServiceProvider::class,
    Providers\DatabaseServiceProvider::class,
];

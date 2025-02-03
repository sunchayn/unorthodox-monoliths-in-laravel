<?php

namespace App\Providers;

use App\Core\Database\Connections\MySqlConnection;
use App\Core\Database\Connections\SQLiteConnection;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Connection::resolverFor('sqlite', fn (...$args): SQLiteConnection => new SQLiteConnection(...$args));
        Connection::resolverFor('mysql', fn (...$args): MySqlConnection => new MySqlConnection(...$args));
    }
}

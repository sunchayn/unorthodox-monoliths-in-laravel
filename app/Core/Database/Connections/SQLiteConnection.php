<?php

namespace App\Core\Database\Connections;

use App\Core\Database\Concerns\HandlesConnectionErrors;

class SQLiteConnection extends \Illuminate\Database\SQLiteConnection
{
    use HandlesConnectionErrors;
}

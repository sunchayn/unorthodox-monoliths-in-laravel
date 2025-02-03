<?php

namespace App\Core\Database\Connections;

use App\Core\Database\Concerns\HandlesConnectionErrors;

class MySqlConnection extends \Illuminate\Database\MySqlConnection
{
    use HandlesConnectionErrors;
}

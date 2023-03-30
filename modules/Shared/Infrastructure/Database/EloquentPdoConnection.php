<?php

namespace TP\Shared\Infrastructure\Database;

use TP\Shared\Lib\Database\PdoConnection;

class EloquentPdoConnection implements PdoConnection
{
    public function getPdo(): \PDO
    {
        return \DB::getPdo();
    }
}

<?php

namespace TP\Shared\Infrastructure\Database;

use TP\Shared\Lib\Database\PdoConnexion;

class EloquentPdoConnexion implements PdoConnexion
{
    public function getPdo(): \PDO
    {
        return \DB::getPdo();
    }
}

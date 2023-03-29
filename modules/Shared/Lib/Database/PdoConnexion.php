<?php

namespace TP\Shared\Lib\Database;

interface PdoConnexion
{
    public function getPdo(): \PDO;
}

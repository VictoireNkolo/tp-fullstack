<?php

namespace TP\Shared\Lib\Database;

interface PdoConnection
{
    public function getPdo(): \PDO;
}

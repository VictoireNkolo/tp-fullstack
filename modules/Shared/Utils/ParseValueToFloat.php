<?php

namespace TP\Shared\Utils;

class ParseValueToFloat
{

    public static function parseValueToFloat(?string $value) : ?float
    {
        if (is_null($value)) {
            return null;
        }
        return (float) str_replace([',', ' '], ['.',''], $value);
    }
}

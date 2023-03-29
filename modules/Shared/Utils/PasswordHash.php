<?php

namespace TP\Shared\Utils;


use Illuminate\Support\Facades\Hash;

class PasswordHash
{

    /**
     * @param string $password
     * @return string
     */
    public static function hash(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * @param string $password
     * @param string $passwordHash
     * @return bool
     */
    public static function check(string $password, string $passwordHash): bool
    {
        return Hash::check($password, $passwordHash);
    }
}

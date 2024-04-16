<?php

namespace Helpers;

class Password
{
    /**
     * @return int
     */
    public static function getSalt(): int
    {
        return rand(10000, 99999);
    }

    /**
     * @param string $password
     * @param int $salt
     * @return string
     */
    public static function getPasswordHash(string $password, int $salt): string
    {
        return sha1($salt . $password);
    }

    /**
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    public static function confirmPassword(string $password, string $confirmPassword): bool
    {
        return $password === $confirmPassword;
    }

    /**
     * @param string $password
     * @param int $salt
     * @param string $hash
     * @return bool
     */
    public static function checkPassword(string $password, int $salt, string $hash): bool
    {
        return self::getPasswordHash($password, $salt) === $hash;
    }
}
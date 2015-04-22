<?php
namespace Ds3\Libraries;

class Password
{
    public static function createSalt()
    {
        $salt = substr(sha1(uniqid(rand(), true)), 0, 12);

        return $salt;
    }

    public static function genPassword($password, $salt)
    {
        return hash('sha256', $password . $salt);
    }
}

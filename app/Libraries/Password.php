<?php

namespace DentalSleepSolutions\Libraries;

// TODO: IMPORTANT! these functions might not be cryptographically secure!
// TODO: it is highly advisable to switch to native Laravel security methods
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

<?php

namespace DentalSleepSolutions\Structs;

use DentalSleepSolutions\Contracts\PasswordInterface;

class Password implements PasswordInterface
{
    /** @var string */
    public $salt;

    /** @var string */
    public $password;

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}

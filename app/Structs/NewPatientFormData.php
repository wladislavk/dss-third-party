<?php

namespace DentalSleepSolutions\Structs;

use DentalSleepSolutions\Contracts\PasswordInterface;
use Illuminate\Contracts\Support\Arrayable;

class NewPatientFormData implements Arrayable, PasswordInterface
{
    /** @var string */
    public $password = '';

    /** @var string */
    public $salt = '';

    /** @var int */
    public $userId;

    /** @var int */
    public $docId;

    /** @var string */
    public $ipAddress;

    /** @var PatientName */
    public $patientName;

    public function __construct()
    {
        $this->patientName = new PatientName();
    }

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

    public function toArray()
    {
        return [
            'password' => $this->password,
            'salt' => $this->salt,
            'userid' => $this->userId,
            'docid' => $this->docId,
            'ip_address' => $this->ipAddress,
            'firstname' => ucfirst($this->patientName->firstName),
            'lastname' => ucfirst($this->patientName->lastName),
            'middlename' => ucfirst($this->patientName->middleName),
        ];
    }
}

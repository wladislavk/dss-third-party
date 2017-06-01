<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class NewPatientFormData implements Arrayable
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

    public function toArray()
    {
        return [
            'password'   => $this->password,
            'salt'       => $this->salt,
            'userid'     => $this->userId,
            'docid'      => $this->docId,
            'ip_address' => $this->ipAddress,
            'firstname'  => ucfirst($this->patientName->firstName),
            'lastname'   => ucfirst($this->patientName->lastName),
            'middlename' => ucfirst($this->patientName->middleName),
        ];
    }
}

<?php

namespace DentalSleepSolutions\Structs;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;

class MailerData
{
    /** @var Patient */
    public $patientData;

    /** @var User */
    public $mailingData;

    public function __construct()
    {
        $this->patientData = new Patient();
        $this->mailingData = new User();
    }
}

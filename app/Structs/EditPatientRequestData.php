<?php

namespace DentalSleepSolutions\Structs;

class EditPatientRequestData
{
    /** @var bool */
    public $hasPatientPortal;

    /** @var bool */
    public $shouldSendIntroLetter;

    /** @var PatientName */
    public $patientName;

    /** @var MDContacts */
    public $mdContacts;

    /** @var int */
    public $ssn;

    /** @var string */
    public $newEmail;

    /** @var string */
    public $cellphone;

    /** @var RequestedEmails */
    public $requestedEmails;

    /** @var PressedButtons */
    public $pressedButtons;

    /** @var int */
    public $patientLocation;

    /** @var PatientReferrer */
    public $referrer;

    /** @var bool */
    public $isInfoComplete;

    /** @var string */
    public $ip;

    /** @var array */
    public $insuranceInfo = [];
}

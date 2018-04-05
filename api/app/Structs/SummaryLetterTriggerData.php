<?php

namespace DentalSleepSolutions\Structs;

class SummaryLetterTriggerData
{
    /** @var int */
    public $patientId = 0;

    /** @var int */
    public $infoId = 0;

    /** @var int */
    public $userId = 0;

    /** @var int */
    public $docId = 0;

    /** @var int */
    public $stepId = 0;

    /** @var int */
    public $letterId = 0;

    /** @var bool */
    public $toPatient = false;

    /** @var int[] */
    public $mdList = [];

    /** @var int[] */
    public $mdReferralList = [];
}

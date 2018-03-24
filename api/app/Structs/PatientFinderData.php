<?php

namespace DentalSleepSolutions\Structs;

class PatientFinderData
{
    /** @var int */
    public $docId = 0;

    /** @var int */
    public $userType = 0;

    /** @var int */
    public $patientId = 0;

    /** @var int */
    public $type = 0;

    /** @var int */
    public $pageNumber = 0;

    /** @var int */
    public $patientsPerPage = 0;

    /** @var string */
    public $letter = '';

    /** @var string */
    public $sortColumn = '';

    /** @var string */
    public $sortDir = 'asc';
}

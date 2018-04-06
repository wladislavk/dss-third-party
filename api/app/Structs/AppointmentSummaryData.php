<?php

namespace DentalSleepSolutions\Structs;

class AppointmentSummaryData
{
    /** @var int */
    public $summaryId = 0;

    /** @var int */
    public $patientId = 0;

    /** @var int */
    public $userId = 0;

    /** @var int */
    public $docId = 0;

    /** @var string|null */
    public $studyType = null;

    /** @var string|null */
    public $delayReason = null;

    /** @var string|null */
    public $nonComplianceReason = null;

    /** @var string|null */
    public $description = null;

    /** @var int */
    public $deviceId = 0;

    /** @var \DateTime|null */
    public $completionDate = null;

    public function setCompletionDate(string $completionDate)
    {
        if ($completionDate) {
            $this->completionDate = new \DateTime($completionDate);
        }
    }
}

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

    /** @var int|null */
    public $deviceId = null;

    /** @var \DateTime|null */
    public $completionDate = null;

    /** @var \DateTime|null */
    public $scheduledDate = null;

    /**
     * @param string $completionDate
     */
    public function setCompletionDate(string $completionDate): void
    {
        if ($completionDate) {
            $this->completionDate = new \DateTime($completionDate);
        }
    }

    /**
     * @param string $scheduledDate
     */
    public function setScheduledDate(string $scheduledDate): void
    {
        if ($scheduledDate) {
            $this->scheduledDate = new \DateTime($scheduledDate);
        }
    }
}

<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Summary;

class PatientLocationRetriever
{
    /** @var Summary */
    private $summaryModel;

    public function __construct(Summary $summaryModel)
    {
        $this->summaryModel = $summaryModel;
    }

    /**
     * @param int $patientId
     * @return int
     */
    public function getPatientLocation($patientId)
    {
        $fields = ['location'];
        $foundLocations = $this->summaryModel->getWithFilter($fields, ['patientid' => $patientId]);
        if (!count($foundLocations)) {
            return 0;
        }
        $foundLocation = $foundLocations[0];
        $patientLocation = $foundLocation->location;
        return $patientLocation;
    }
}

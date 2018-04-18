<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\SummaryRepository;

class PatientLocationRetriever
{
    /** @var SummaryRepository */
    private $summaryRepository;

    public function __construct(SummaryRepository $summaryRepository)
    {
        $this->summaryRepository = $summaryRepository;
    }

    /**
     * @param int $patientId
     * @return int
     */
    public function getPatientLocation($patientId)
    {
        $fields = ['location'];
        $foundLocations = $this->summaryRepository->getWithFilter($fields, ['patientid' => $patientId]);
        if (!count($foundLocations)) {
            return 0;
        }
        $foundLocation = $foundLocations[0];
        $patientLocation = $foundLocation->location;
        return $patientLocation;
    }
}

<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Dental\Summary;

class PatientSummaryManager
{
    /** @var Summary */
    private $summaryModel;

    /** @var PatientSummary */
    private $patientSummaryModel;

    public function __construct(Summary $summaryModel, PatientSummary $patientSummaryModel)
    {
        $this->summaryModel = $summaryModel;
        $this->patientSummaryModel = $patientSummaryModel;
    }

    /**
     * @param int $patientId
     * @param int $patientLocation
     */
    public function createSummary($patientId, $patientLocation)
    {
        if (!$patientLocation) {
            return;
        }
        $summaryData = [
            'location'  => $patientLocation,
            'patientid' => $patientId,
        ];
        $this->summaryModel->create($summaryData);
    }

    /**
     * @param int $patientId
     * @param int $patientLocation
     */
    public function updateSummaryWithLocation($patientId, $patientLocation)
    {
        if (!$patientLocation) {
            return;
        }
        $summaries = $this->summaryModel->getWithFilter(null, ['patientid' => $patientId]);
        if (count($summaries)) {
            $summaryData = ['location' => $patientLocation];
            $this->summaryModel->updateForPatient($patientId, $summaryData);
            return;
        }
        $this->createSummary($patientId, $patientLocation);
    }

    /**
     * @param int $patientId
     * @param bool $isInfoComplete
     */
    public function updatePatientSummary($patientId, $isInfoComplete)
    {
        if (!$patientId) {
            return;
        }
        /** @var PatientSummary|null $patientSummary */
        $patientSummary = $this->patientSummaryModel->find($patientId);
        if ($patientSummary) {
            $patientSummary->patient_info = $isInfoComplete;
            $patientSummary->save();
            return;
        }
        $patientSummaryData = [
            'pid'   => $patientId,
            'patient_info' => $isInfoComplete,
        ];
        $this->patientSummaryModel->create($patientSummaryData);
    }
}

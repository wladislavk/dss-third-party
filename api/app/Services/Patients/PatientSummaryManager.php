<?php

namespace DentalSleepSolutions\Services\Patients;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SummaryRepository;

class PatientSummaryManager
{
    /** @var SummaryRepository */
    private $summaryRepository;

    /** @var PatientSummaryRepository */
    private $patientSummaryRepository;

    public function __construct(
        SummaryRepository $summaryRepository,
        PatientSummaryRepository $patientSummaryRepository
    ) {
        $this->summaryRepository = $summaryRepository;
        $this->patientSummaryRepository = $patientSummaryRepository;
    }

    /**
     * @param int $patientId
     * @param int $patientLocation
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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
        $this->summaryRepository->create($summaryData);
    }

    /**
     * @param int $patientId
     * @param int $patientLocation
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateSummaryWithLocation($patientId, $patientLocation)
    {
        if (!$patientLocation) {
            return;
        }
        $summaries = $this->summaryRepository->getWithFilter([], ['patientid' => $patientId]);
        if (count($summaries)) {
            $summaryData = ['location' => $patientLocation];
            $this->summaryRepository->updateForPatient($patientId, $summaryData);
            return;
        }
        $this->createSummary($patientId, $patientLocation);
    }

    /**
     * @param int $patientId
     * @param bool $isInfoComplete
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updatePatientSummary($patientId, $isInfoComplete)
    {
        if (!$patientId) {
            return;
        }
        $patientSummaryData = [
            'patient_info' => $isInfoComplete,
        ];
        /** @var PatientSummary|null $patientSummary */
        $patientSummary = $this->patientSummaryRepository->find($patientId);
        if ($patientSummary) {
            $this->patientSummaryRepository->update($patientSummaryData, $patientSummary->pid);
            return;
        }
        $patientSummaryData['pid'] = $patientId;
        $this->patientSummaryRepository->create($patientSummaryData);
    }
}

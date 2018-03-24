<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Exceptions\GeneralException;

class TrackerNotesHandler
{
    /** @var PatientRepository */
    private $patientRepository;

    /** @var PatientSummaryRepository */
    private $patientSummaryRepository;

    public function __construct(
        PatientRepository $patientRepository,
        PatientSummaryRepository $patientSummaryRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->patientSummaryRepository = $patientSummaryRepository;
    }

    public function retrieve(int $patientId): string
    {
        /** @var PatientSummary|null $summary */
        $summary = $this->patientSummaryRepository->getOneBy('pid', $patientId);
        if ($summary) {
            return $summary->tracker_notes;
        }
        return '';
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param string $notes
     * @throws GeneralException
     */
    public function update(int $patientId, int $docId, string $notes): void
    {
        /** @var Patient|null $patient */
        $patient = $this->patientRepository->find($patientId);
        if (!$patient || $patient->docid != $docId) {
            throw new GeneralException("Patient with ID $patientId not found or does not belong to the current doctor");
        }
        // Summaries share PK with patients
        /** @var PatientSummary|null $summary */
        $summary = $this->patientSummaryRepository->find($patientId);
        if (!$summary) {
            throw new GeneralException("Patient with ID $patientId does not have a summary");
        }
        $summary->tracker_notes = $notes;
        $summary->save();
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PatientSummaryRepository extends AbstractRepository
{
    public function model()
    {
        return PatientSummary::class;
    }

    /**
     * @param int $patientId
     * @return string
     */
    public function getTrackerNotes(int $patientId): string
    {
        $trackerNotes = $this->model->where('pid', $patientId)->first();
        if ($trackerNotes) {
            $trackerNotesArray = $trackerNotes->toArray();
            return $trackerNotesArray['tracker_notes'];
        }
        return '';
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param string $notes
     * @return bool|int
     */
    public function updateTrackerNotes(int $patientId, int $docId, string $notes)
    {
        return $this->model->from(\DB::raw('dental_patient_summary summary'))
            ->leftJoin(\DB::raw('dental_patients patient'), 'patient.patientid', '=', 'summary.pid')
            ->where('summary.pid', $patientId)
            ->where('patient.docid', $docId)
            ->update(['summary.tracker_notes' => $notes]);
    }

    /**
     * @param int $patientId
     * @return PatientSummary|null
     */
    public function getPatientInfo(int $patientId): ?PatientSummary
    {
        /** @var PatientSummary|null $patientSummary */
        $patientSummary = $this->model->select('patient_info')
            ->where('pid', $patientId)
            ->first();
        return $patientSummary;
    }

    /**
     * @param int $patientId
     * @param array $data
     * @return bool|int
     */
    public function updatePatientSummary(int $patientId, array $data)
    {
        return $this->model
            ->where('pid', $patientId)
            ->update($data)
        ;
    }
}

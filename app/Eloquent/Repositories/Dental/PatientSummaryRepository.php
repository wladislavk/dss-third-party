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

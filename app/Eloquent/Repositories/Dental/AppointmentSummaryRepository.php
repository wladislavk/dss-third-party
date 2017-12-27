<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AppointmentSummaryRepository extends AbstractRepository
{
    public function model()
    {
        return AppointmentSummary::class;
    }

    /**
     * @param int $patientId
     * @return AppointmentSummary[]|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByPatient($patientId)
    {
        return $this->model->select('*')
            ->where('patientid', $patientId)
            ->orderBy('date_completed', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }
}

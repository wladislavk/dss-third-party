<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SummaryRepository extends AbstractRepository
{
    public function model()
    {
        return Summary::class;
    }

    /**
     * @param int $patientId
     * @param array $data
     */
    public function updateForPatient($patientId, array $data)
    {
        $this->model->where('patientid', $patientId)->update($data);
    }
}

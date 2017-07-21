<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SummSleeplab;
use Prettus\Repository\Eloquent\BaseRepository;

class SummSleeplabRepository extends BaseRepository
{
    public function model()
    {
        return SummSleeplab::class;
    }

    /**
     * @param int $patientId
     * @return SummSleeplab|null
     */
    public function getPatientDiagnosis($patientId)
    {
        /** @var SummSleeplab|null $diagnosis */
        $diagnosis = $this->model->select('diagnosis')
            ->where(function($query) {
                $query->whereNotNull('diagnosis')
                    ->where('diagnosis', '!=', '');
            })->whereNotNull('filename')
            ->where('patiendid', $patientId)
            ->orderBy('id', 'desc')
            ->first();
        return $diagnosis;
    }
}

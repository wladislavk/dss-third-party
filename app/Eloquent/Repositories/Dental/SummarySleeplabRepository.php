<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SummarySleeplab;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class SummarySleeplabRepository extends AbstractRepository
{
    public function model()
    {
        return SummarySleeplab::class;
    }

    /**
     * @param int $patientId
     * @return SummarySleeplab|null
     */
    public function getPatientDiagnosis($patientId)
    {
        /** @var SummarySleeplab|null $diagnosis */
        $diagnosis = $this->model->select('diagnosis')
            ->where(function (Builder $query) {
                $query->whereNotNull('diagnosis')
                    ->where('diagnosis', '!=', '');
            })->whereNotNull('filename')
            ->where('patiendid', $patientId)
            ->orderBy('id', 'desc')
            ->first();
        return $diagnosis;
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Query\Builder;

class HomeSleepTestRepository extends AbstractRepository
{
    public function model()
    {
        return HomeSleepTest::class;
    }

    /**
     * @param int $patientId
     * @return mixed
     */
    public function getUncompleted($patientId)
    {
        return $this->model->where(function (Builder $query) {
            $query->requested()->orPending()->orScheduled()->orRejected();
        })->where('patient_id', $patientId)->get();
    }

    /**
     * @param int $docId
     * @return mixed
     */
    public function getCompleted($docId)
    {
        return $this->model->base($docId)->completed()->first();
    }

    /**
     * @param int $docId
     * @return mixed
     */
    public function getRequested($docId)
    {
        return $this->model->base($docId)->requested()->first();
    }

    /**
     * @param int $docId
     * @return mixed
     */
    public function getRejected($docId)
    {
        return $this->model->base($docId)->rejected()->first();
    }
}

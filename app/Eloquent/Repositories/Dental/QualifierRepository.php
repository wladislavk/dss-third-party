<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Qualifier;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class QualifierRepository extends AbstractRepository
{
    public function model()
    {
        return Qualifier::class;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getActive()
    {
        return $this->model->active()->orderBy('sortby')->get();
    }
}

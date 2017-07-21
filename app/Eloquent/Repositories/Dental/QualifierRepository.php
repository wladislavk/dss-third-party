<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Qualifier;
use Prettus\Repository\Eloquent\BaseRepository;

class QualifierRepository extends BaseRepository
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

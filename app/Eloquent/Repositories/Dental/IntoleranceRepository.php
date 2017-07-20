<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Intolerance;
use Prettus\Repository\Eloquent\BaseRepository;

class IntoleranceRepository extends BaseRepository
{
    public function model()
    {
        return Intolerance::class;
    }
}

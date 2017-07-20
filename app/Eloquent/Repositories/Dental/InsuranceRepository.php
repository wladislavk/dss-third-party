<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceRepository extends BaseRepository
{
    public function model()
    {
        return Insurance::class;
    }
}

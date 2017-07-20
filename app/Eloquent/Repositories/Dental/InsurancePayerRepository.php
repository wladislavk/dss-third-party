<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePayer;
use Prettus\Repository\Eloquent\BaseRepository;

class InsurancePayerRepository extends BaseRepository
{
    public function model()
    {
        return InsurancePayer::class;
    }
}

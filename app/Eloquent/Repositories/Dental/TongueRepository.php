<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Tongue;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TongueRepository extends AbstractRepository
{
    public function model()
    {
        return Tongue::class;
    }
}

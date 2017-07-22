<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Chair;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ChairRepository extends AbstractRepository
{
    public function model()
    {
        return Chair::class;
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Thorton;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ThortonRepository extends AbstractRepository
{
    public function model()
    {
        return Thorton::class;
    }
}

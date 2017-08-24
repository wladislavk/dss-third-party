<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Uvula;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class UvulaRepository extends AbstractRepository
{
    public function model()
    {
        return Uvula::class;
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Palpation;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PalpationRepository extends AbstractRepository
{
    public function model()
    {
        return Palpation::class;
    }
}

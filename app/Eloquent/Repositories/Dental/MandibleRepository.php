<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Mandible;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class MandibleRepository extends AbstractRepository
{
    public function model()
    {
        return Mandible::class;
    }
}

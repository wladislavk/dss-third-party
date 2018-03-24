<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Maxilla;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class MaxillaRepository extends AbstractRepository
{
    public function model()
    {
        return Maxilla::class;
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GagReflex;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class GagReflexRepository extends AbstractRepository
{
    public function model()
    {
        return GagReflex::class;
    }
}

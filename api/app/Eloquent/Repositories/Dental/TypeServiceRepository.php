<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TypeService;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TypeServiceRepository extends AbstractRepository
{
    public function model()
    {
        return TypeService::class;
    }
}

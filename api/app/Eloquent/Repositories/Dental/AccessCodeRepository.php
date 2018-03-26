<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AccessCode;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AccessCodeRepository extends AbstractRepository
{
    public function model()
    {
        return AccessCode::class;
    }
}

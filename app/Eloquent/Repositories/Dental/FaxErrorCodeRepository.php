<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FaxErrorCode;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class FaxErrorCodeRepository extends AbstractRepository
{
    public function model()
    {
        return FaxErrorCode::class;
    }
}

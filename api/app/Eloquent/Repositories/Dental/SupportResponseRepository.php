<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SupportResponseRepository extends AbstractRepository
{
    public function model()
    {
        return SupportResponse::class;
    }
}

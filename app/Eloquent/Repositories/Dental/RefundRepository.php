<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Refund;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class RefundRepository extends AbstractRepository
{
    public function model()
    {
        return Refund::class;
    }
}

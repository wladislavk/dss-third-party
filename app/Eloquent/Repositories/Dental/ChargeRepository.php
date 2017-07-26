<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Charge;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ChargeRepository extends AbstractRepository
{
    public function model()
    {
        return Charge::class;
    }
}

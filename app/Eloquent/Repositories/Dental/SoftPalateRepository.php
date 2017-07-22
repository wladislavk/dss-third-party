<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SoftPalate;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SoftPalateRepository extends AbstractRepository
{
    public function model()
    {
        return SoftPalate::class;
    }
}

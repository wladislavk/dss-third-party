<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimText;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ClaimTextRepository extends AbstractRepository
{
    public function model()
    {
        return ClaimText::class;
    }
}

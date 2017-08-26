<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class FlowsheetRepository extends AbstractRepository
{
    public function model()
    {
        return Flowsheet::class;
    }
}

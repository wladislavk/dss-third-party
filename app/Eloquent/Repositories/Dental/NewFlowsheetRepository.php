<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class NewFlowsheetRepository extends AbstractRepository
{
    public function model()
    {
        return NewFlowsheet::class;
    }
}

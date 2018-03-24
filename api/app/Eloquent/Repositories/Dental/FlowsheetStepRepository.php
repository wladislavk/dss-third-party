<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetStep;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class FlowsheetStepRepository extends AbstractRepository
{
    public function model()
    {
        return FlowsheetStep::class;
    }
}

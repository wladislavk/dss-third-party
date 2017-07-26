<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class FlowsheetNextStepRepository extends AbstractRepository
{
    public function model()
    {
        return FlowsheetNextStep::class;
    }
}

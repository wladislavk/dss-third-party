<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\FlowsheetSegment;

class FlowsheetSegmentRepository extends AbstractRepository
{
    public function model()
    {
        return FlowsheetSegment::class;
    }
}

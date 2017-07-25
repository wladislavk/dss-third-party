<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PreviousTreatment;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PreviousTreatmentRepository extends AbstractRepository
{
    public function model()
    {
        return PreviousTreatment::class;
    }
}

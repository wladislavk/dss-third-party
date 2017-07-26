<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceType;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class InsuranceTypeRepository extends AbstractRepository
{
    public function model()
    {
        return InsuranceType::class;
    }
}

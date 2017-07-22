<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePayer;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class InsurancePayerRepository extends AbstractRepository
{
    public function model()
    {
        return InsurancePayer::class;
    }
}

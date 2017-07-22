<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceHistory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class InsuranceHistoryRepository extends AbstractRepository
{
    public function model()
    {
        return InsuranceHistory::class;
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceStatusHistory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class InsuranceStatusHistoryRepository extends AbstractRepository
{
    public function model()
    {
        return InsuranceStatusHistory::class;
    }
}

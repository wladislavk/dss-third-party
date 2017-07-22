<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\HealthHistory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class HealthHistoryRepository extends AbstractRepository
{
    public function model()
    {
        return HealthHistory::class;
    }
}

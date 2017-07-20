<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\HealthHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class HealthHistoryRepository extends BaseRepository
{
    public function model()
    {
        return HealthHistory::class;
    }
}

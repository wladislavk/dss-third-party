<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceHistoryRepository extends BaseRepository
{
    public function model()
    {
        return InsuranceHistory::class;
    }
}

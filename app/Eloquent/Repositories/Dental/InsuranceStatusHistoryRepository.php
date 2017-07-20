<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceStatusHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceStatusHistoryRepository extends BaseRepository
{
    public function model()
    {
        return InsuranceStatusHistory::class;
    }
}

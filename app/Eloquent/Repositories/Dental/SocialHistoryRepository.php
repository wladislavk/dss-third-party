<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SocialHistory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SocialHistoryRepository extends AbstractRepository
{
    public function model()
    {
        return SocialHistory::class;
    }
}

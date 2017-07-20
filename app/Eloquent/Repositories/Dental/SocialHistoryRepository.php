<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SocialHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class SocialHistoryRepository extends BaseRepository
{
    public function model()
    {
        return SocialHistory::class;
    }
}

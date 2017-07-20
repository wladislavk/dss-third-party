<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerHistoryRepository extends BaseRepository
{
    public function model()
    {
        return LedgerHistory::class;
    }
}

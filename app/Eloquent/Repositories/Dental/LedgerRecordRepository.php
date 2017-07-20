<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerRecord;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerRecordRepository extends BaseRepository
{
    public function model()
    {
        return LedgerRecord::class;
    }
}

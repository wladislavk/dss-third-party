<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerRecord;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LedgerRecordRepository extends AbstractRepository
{
    public function model()
    {
        return LedgerRecord::class;
    }
}

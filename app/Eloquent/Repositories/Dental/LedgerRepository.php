<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Ledger;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerRepository extends BaseRepository
{
    public function model()
    {
        return Ledger::class;
    }
}

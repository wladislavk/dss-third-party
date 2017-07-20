<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerStatementRepository extends BaseRepository
{
    public function model()
    {
        return LedgerStatement::class;
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerPaymentHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerPaymentHistoryRepository extends BaseRepository
{
    public function model()
    {
        return LedgerPaymentHistory::class;
    }
}

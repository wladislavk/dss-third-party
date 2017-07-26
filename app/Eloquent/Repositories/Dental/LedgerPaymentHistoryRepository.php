<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerPaymentHistory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LedgerPaymentHistoryRepository extends AbstractRepository
{
    public function model()
    {
        return LedgerPaymentHistory::class;
    }
}

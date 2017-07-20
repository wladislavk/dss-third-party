<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerPayment;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerPaymentRepository extends BaseRepository
{
    public function model()
    {
        return LedgerPayment::class;
    }
}

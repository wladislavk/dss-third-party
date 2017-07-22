<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerPayment;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LedgerPaymentRepository extends AbstractRepository
{
    public function model()
    {
        return LedgerPayment::class;
    }
}

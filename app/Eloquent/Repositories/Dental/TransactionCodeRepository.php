<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TransactionCode;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TransactionCodeRepository extends AbstractRepository
{
    public function model()
    {
        return TransactionCode::class;
    }
}

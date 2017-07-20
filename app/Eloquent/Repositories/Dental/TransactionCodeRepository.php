<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TransactionCode;
use Prettus\Repository\Eloquent\BaseRepository;

class TransactionCodeRepository extends BaseRepository
{
    public function model()
    {
        return TransactionCode::class;
    }
}

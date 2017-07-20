<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Refund;
use Prettus\Repository\Eloquent\BaseRepository;

class RefundRepository extends BaseRepository
{
    public function model()
    {
        return Refund::class;
    }
}

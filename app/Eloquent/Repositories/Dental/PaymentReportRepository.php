<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PaymentReport;
use Prettus\Repository\Eloquent\BaseRepository;

class PaymentReportRepository extends BaseRepository
{
    public function model()
    {
        return PaymentReport::class;
    }
}

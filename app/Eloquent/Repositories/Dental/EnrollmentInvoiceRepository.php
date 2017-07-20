<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\EnrollmentInvoice;
use Prettus\Repository\Eloquent\BaseRepository;

class EnrollmentInvoiceRepository extends BaseRepository
{
    public function model()
    {
        return EnrollmentInvoice::class;
    }
}

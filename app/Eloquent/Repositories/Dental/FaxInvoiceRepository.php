<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FaxInvoice;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class FaxInvoiceRepository extends AbstractRepository
{
    public function model()
    {
        return FaxInvoice::class;
    }
}

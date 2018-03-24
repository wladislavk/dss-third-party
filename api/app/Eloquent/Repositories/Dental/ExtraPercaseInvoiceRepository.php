<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExtraPercaseInvoice;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ExtraPercaseInvoiceRepository extends AbstractRepository
{
    public function model()
    {
        return ExtraPercaseInvoice::class;
    }
}

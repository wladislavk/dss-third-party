<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FaxInvoice;
use Prettus\Repository\Eloquent\BaseRepository;

class FaxInvoiceRepository extends BaseRepository
{
    public function model()
    {
        return FaxInvoice::class;
    }
}

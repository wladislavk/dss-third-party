<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PercaseInvoice;
use Prettus\Repository\Eloquent\BaseRepository;

class PercaseInvoiceRepository extends BaseRepository
{
    public function model()
    {
        return PercaseInvoice::class;
    }
}

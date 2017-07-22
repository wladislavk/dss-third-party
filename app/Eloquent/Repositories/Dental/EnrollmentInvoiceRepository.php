<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\EnrollmentInvoice;
use Prettus\Repository\Eloquent\BaseRepository;

class EnrollmentInvoiceRepository extends BaseRepository
{
    public function model()
    {
        return EnrollmentInvoice::class;
    }

    /**
     * @param int $invoiceId
     * @param string $ip
     * @return int
     */
    public function add($invoiceId, $ip)
    {
        $enrollmentInvoice = new EnrollmentInvoice();
        $enrollmentInvoice->invoice_id = $invoiceId;
        $enrollmentInvoice->adddate = Carbon::now();
        $enrollmentInvoice->ip_address = $ip;
        $enrollmentInvoice->save();

        return $enrollmentInvoice->id;
    }
}

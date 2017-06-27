<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\AbstractModel;

class EnrollmentInvoice extends AbstractModel
{
    protected $table = 'dental_enrollment_invoice';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * add new record
     *
     * @param int $invoice_id
     * @param string $ip
     * @return int
     */
    public static function add($invoice_id, $ip)
    {
        $enrollment_invoice = new static;
        $enrollment_invoice->invoice_id = $invoice_id;
        $enrollment_invoice->adddate = Carbon::now();
        $enrollment_invoice->ip_address = $ip;
        $enrollment_invoice->save();

        return $enrollment_invoice->id;
    }
}

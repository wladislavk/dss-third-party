<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EnrollmentInvoice extends Model
{
    protected $table = 'dental_enrollment_invoice';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * add new record
     *
     * @param $invoice_id
     * @param $ip
     * @return mixed
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

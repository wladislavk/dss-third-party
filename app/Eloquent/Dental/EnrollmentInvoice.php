<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\AbstractModel;

/**
 * DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $amount
 * @property string|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereStartDate($value)
 * @mixin \Eloquent
 */
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

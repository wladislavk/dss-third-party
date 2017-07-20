<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="EnrollmentInvoice",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="invoice_id", type="integer"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="start_date", type="string"),
 *     @SWG\Property(property="end_date", type="string"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
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

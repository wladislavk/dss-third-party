<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

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
}

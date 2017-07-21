<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="FaxInvoice",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="invoice_id", type="integer"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="start_date", type="string", format="dateTime"),
 *     @SWG\Property(property="end_date", type="string", format="dateTime"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\FaxInvoice
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property string|null $description
 * @property \Carbon\Carbon|null $start_date
 * @property \Carbon\Carbon|null $end_date
 * @property float|null $amount
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class FaxInvoice extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'description',
        'start_date',
        'end_date',
        'amount',
        'adddate',
        'ip_address',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_fax_invoice';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

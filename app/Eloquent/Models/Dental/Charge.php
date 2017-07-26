<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Charge",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="adminid", type="integer"),
 *     @SWG\Property(property="charge_date", type="string"),
 *     @SWG\Property(property="stripe_customer", type="string"),
 *     @SWG\Property(property="stripe_charge", type="string"),
 *     @SWG\Property(property="stripe_card_fingerprint", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="invoice_id", type="integer"),
 *     @SWG\Property(property="status", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Charge
 *
 * @property int $id
 * @property float|null $amount
 * @property int|null $userid
 * @property int|null $adminid
 * @property string|null $charge_date
 * @property string|null $stripe_customer
 * @property string|null $stripe_charge
 * @property string|null $stripe_card_fingerprint
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $invoice_id
 * @property int|null $status
 * @mixin \Eloquent
 */
class Charge extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'userid',
        'adminid',
        'charge_date',
        'stripe_customer',
        'stripe_charge',
        'stripe_card_fingerprint',
        'adddate',
        'ip_address',
        'invoice_id',
        'status',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_charge';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';
}

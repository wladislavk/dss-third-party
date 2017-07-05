<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Charge as Resource;
use DentalSleepSolutions\Contracts\Repositories\Charges as Repository;

/**
 * @SWG\Definition(
 *     definition="Charge",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="adminid", type="integer"),
 *     @SWG\Property(property="charge", type="string"),
 *     @SWG\Property(property="stripe", type="string"),
 *     @SWG\Property(property="stripe", type="string"),
 *     @SWG\Property(property="stripe", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="invoice", type="integer"),
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereChargeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStripeCardFingerprint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStripeCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStripeCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereUserid($value)
 * @mixin \Eloquent
 */
class Charge extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'userid', 'adminid',
        'charge_date', 'stripe_customer', 'stripe_charge',
        'stripe_card_fingerprint', 'adddate', 'ip_address',
        'invoice_id', 'status'
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

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

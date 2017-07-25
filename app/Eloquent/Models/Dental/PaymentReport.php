<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="PaymentReport",
 *     type="object",
 *     required={"payment_id"},
 *     @SWG\Property(property="payment_id", type="integer"),
 *     @SWG\Property(property="claimid", type="integer"),
 *     @SWG\Property(property="reference_id", type="string"),
 *     @SWG\Property(property="response", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="viewed", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\PaymentReport
 *
 * @property int $payment_id
 * @property int|null $claimid
 * @property string|null $reference_id
 * @property string|null $response
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $viewed
 * @mixin \Eloquent
 */
class PaymentReport extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'claimid',
        'reference_id',
        'response',
        'adddate',
        'ip_address',
        'viewed',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_payment_reports';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'payment_id';

    const CREATED_AT = 'adddate';
}

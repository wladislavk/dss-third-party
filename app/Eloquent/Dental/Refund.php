<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Refund as Resource;
use DentalSleepSolutions\Contracts\Repositories\Refunds as Repository;

/**
 * @SWG\Definition(
 *     definition="Refund",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="adminid", type="integer"),
 *     @SWG\Property(property="refund", type="string", format="dateTime"),
 *     @SWG\Property(property="charge", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Refund
 *
 * @property int $id
 * @property float|null $amount
 * @property int|null $userid
 * @property int|null $adminid
 * @property \Carbon\Carbon|null $refund_date
 * @property int|null $charge_id
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereChargeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereRefundDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereUserid($value)
 * @mixin \Eloquent
 */
class Refund extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'userid', 'adminid', 'refund_date',
        'charge_id', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_refund';

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
    protected $dates = ['refund_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

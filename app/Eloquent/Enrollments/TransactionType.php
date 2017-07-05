<?php

namespace DentalSleepSolutions\Eloquent\Enrollments;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *     definition="TransactionType",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="transaction", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="endpoint", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Enrollments\TransactionType
 *
 * @property int $id
 * @property string|null $transaction_type
 * @property string|null $description
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property int|null $status
 * @property string|null $endpoint_type
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereEndpointType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereTransactionType($value)
 * @mixin \Eloquent
 */
class TransactionType extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'transaction_type', 'description', 'addddate',
        'ip_address', 'status', 'endpoint',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_enrollment_transaction_type';

    /**
     * @var bool
     */
    public $timestamps = false;
}

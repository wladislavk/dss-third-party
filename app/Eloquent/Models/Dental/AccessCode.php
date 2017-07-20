<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="AccessCode",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="access_code", type="string"),
 *     @SWG\Property(property="notes", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="plan_id", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\AccessCode
 *
 * @property int $id
 * @property string|null $access_code
 * @property string|null $notes
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $plan_id
 * @mixin \Eloquent
 */
class AccessCode extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'access_code', 'notes', 'status',
        'adddate', 'ip_address', 'plan_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_access_codes';

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

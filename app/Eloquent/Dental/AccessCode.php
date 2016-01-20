<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\AccessCode as Resource;
use DentalSleepSolutions\Contracts\Repositories\AccessCodes as Repository;

class AccessCode extends Model implements Resource, Repository
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

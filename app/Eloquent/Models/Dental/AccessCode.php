<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Repositories\Repository;

class AccessCode extends AbstractModel implements Resource, Repository
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

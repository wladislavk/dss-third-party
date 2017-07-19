<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\GagReflex as Resource;
use DentalSleepSolutions\Contracts\Repositories\GagReflexes as Repository;

class GagReflex extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'gag_reflex', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_gag_reflex';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'gag_reflexid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

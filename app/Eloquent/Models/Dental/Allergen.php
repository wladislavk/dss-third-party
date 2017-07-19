<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Allergen as Resource;
use DentalSleepSolutions\Contracts\Repositories\Allergens as Repository;

class Allergen extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'allergens', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_allergens';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'allergensid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

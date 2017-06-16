<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\CustomText as Resource;
use DentalSleepSolutions\Contracts\Repositories\CustomTexts as Repository;

class CustomText extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'docid', 'status',
        'adddate', 'ip_address', 'default_text'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_custom';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'customid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

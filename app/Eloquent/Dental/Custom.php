<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Device as Resource;
use DentalSleepSolutions\Contracts\Repositories\Devices as Repository;

class Custom extends Model implements Resource, Repository
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

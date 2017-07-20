<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

class Calendar extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'start_date', 'end_date', 'description',
        'event_id', 'docid', 'adddate',
        'ip_address', 'category', 'producer_id',
        'patientid', 'rec_type', 'event_length',
        'event_pid', 'res_id', 'rec_pattern'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_calendar';

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

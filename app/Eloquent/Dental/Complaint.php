<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Complaint as Resource;
use DentalSleepSolutions\Contracts\Repositories\Complaints as Repository;

class Complaint extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'complaint', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_complaint';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'complaintid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

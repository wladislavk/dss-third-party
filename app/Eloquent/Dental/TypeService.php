<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\TypeService as Resource;
use DentalSleepSolutions\Contracts\Repositories\TypeServices as Repository;

class TypeService extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['type_serviceid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_type_service';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'type_serviceid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

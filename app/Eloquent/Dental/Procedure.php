<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Procedure as Resource;
use DentalSleepSolutions\Contracts\Repositories\Procedures as Repository;

class Procedure extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['procedureid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_procedure';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'procedureid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

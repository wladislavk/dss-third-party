<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Sleeplab as Resource;
use DentalSleepSolutions\Contracts\Repositories\Sleeplabs as Repository;

class Sleeplab extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['sleeplabid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_sleeplab';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sleeplabid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

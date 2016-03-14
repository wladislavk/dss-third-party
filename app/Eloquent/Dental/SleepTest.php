<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\SleepTest as Resource;
use DentalSleepSolutions\Contracts\Repositories\SleepTests as Repository;

class SleepTest extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_sleepid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_sleep';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_sleepid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

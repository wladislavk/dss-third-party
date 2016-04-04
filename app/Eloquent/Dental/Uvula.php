<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Uvula as Resource;
use DentalSleepSolutions\Contracts\Repositories\Uvulas as Repository;

class Uvula extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['uvulaid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_uvula';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uvulaid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

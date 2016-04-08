<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\MissingTooth as Resource;
use DentalSleepSolutions\Contracts\Repositories\MissingTeeth as Repository;

class MissingTooth extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['missingid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_missing';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'missingid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

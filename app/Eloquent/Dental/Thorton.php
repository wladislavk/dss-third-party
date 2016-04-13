<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Thorton as Resource;
use DentalSleepSolutions\Contracts\Repositories\Thortons as Repository;

class Thorton extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['thortonid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_thorton';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'thortonid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Flowsheet as Resource;
use DentalSleepSolutions\Contracts\Repositories\Flowsheets as Repository;

class Flowsheet extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['flowsheetid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_flowsheet';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'flowsheetid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

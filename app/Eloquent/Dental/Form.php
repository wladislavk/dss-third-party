<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Form as Resource;
use DentalSleepSolutions\Contracts\Repositories\Forms as Repository;

class Form extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['formid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_forms';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'formid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

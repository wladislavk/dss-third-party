<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;

class Procedure extends Model
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

<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Qualifier as Resource;
use DentalSleepSolutions\Contracts\Repositories\Qualifiers as Repository;

class Qualifier extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['qualifierid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_qualifier';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'qualifierid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

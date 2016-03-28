<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Summary as Resource;
use DentalSleepSolutions\Contracts\Repositories\Summaries as Repository;

class Summary extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['summaryid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_summary';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'summaryid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

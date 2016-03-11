<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Recipient as Resource;
use DentalSleepSolutions\Contracts\Repositories\Recipients as Repository;

class Recipient extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_recipientsid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_recipients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_recipientsid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

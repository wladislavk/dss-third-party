<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Chair as Resource;
use DentalSleepSolutions\Contracts\Repositories\Chairs as Repository;

class Chair extends Model implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'rank', 'docid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_resources';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}

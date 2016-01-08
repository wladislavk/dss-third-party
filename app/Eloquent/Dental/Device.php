<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Device as Resource;
use DentalSleepSolutions\Contracts\Repositories\Devices as Repository;

class Device extends Model implements Resource, Repository
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_device';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'deviceid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}

<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Device as Resource;
use DentalSleepSolutions\Contracts\Repositories\Devices as Repository;

class Device extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'device', 'description', 'sortby',
        'status', 'adddate', 'ip_address',
        'image_path'
    ];

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
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

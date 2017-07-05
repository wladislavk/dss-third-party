<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Device as Resource;
use DentalSleepSolutions\Contracts\Repositories\Devices as Repository;

/**
 * @SWG\Definition(
 *     definition="Device",
 *     type="object",
 *     required={"deviceid", "ip"},
 *     @SWG\Property(property="deviceid", type="integer"),
 *     @SWG\Property(property="device", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="image", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Device
 *
 * @property int $deviceid
 * @property string|null $device
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @property string|null $image_path
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereDeviceid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereStatus($value)
 * @mixin \Eloquent
 */
class Device extends AbstractModel implements Resource, Repository
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

    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }
}

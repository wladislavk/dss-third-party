<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Device",
 *     type="object",
 *     required={"deviceid", "ip_address"},
 *     @SWG\Property(property="deviceid", type="integer"),
 *     @SWG\Property(property="device", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="image_path", type="string")
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
 * @mixin \Eloquent
 */
class Device extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'device',
        'description',
        'sortby',
        'status',
        'adddate',
        'ip_address',
        'image_path',
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

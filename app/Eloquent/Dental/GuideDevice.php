<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\GuideDevice as Resource;
use DentalSleepSolutions\Contracts\Repositories\GuideDevices as Repository;

/**
 * @SWG\Definition(
 *     definition="GuideDevice",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="deviceSettings", type="array", @SWG\Items(ref="#/definitions/GuideDeviceSetting"))
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\GuideDevice
 *
 * @property int $id
 * @property string|null $name
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting[] $deviceSettings
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereName($value)
 * @mixin \Eloquent
 */
class GuideDevice extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_device_guide_devices';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';


    /**
     * RELATIONS
     */
    public function deviceSettings()
    {
        return $this->hasMany(GuideDeviceSetting::class, 'id', 'device_id');
    }
}

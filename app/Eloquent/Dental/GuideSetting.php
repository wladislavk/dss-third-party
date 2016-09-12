<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\GuideSetting as Resource;
use DentalSleepSolutions\Contracts\Repositories\GuideSettings as Repository;
use DB;

class GuideSetting extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'setting_type', 'range_start',
        'range_end', 'adddate', 'ip_address',
        'rank', 'options', 'range_start_label',
        'range_end_label'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_device_guide_settings';

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
    public function options()
    {
        return $this->hasMany(GuideSettingOption::class, 'setting_id', 'id');
    }

    /**
     * RELATIONS
     */
    public function deviceSettings()
    {
        return $this->hasMany(GuideDeviceSetting::class, 'id', 'setting_id');
    }

    public function getAllOrderBy($order = 'name')
    {
        return $this->orderBy($order)
            ->get();
    }

    public function getSettingType($deviceId = 0)
    {
        return $this->select('s.id', 's.setting_type', 'ds.value')
            ->from(DB::raw('dental_device_guide_settings s'))
            ->leftJoin(DB::raw('dental_device_guide_device_setting ds'), function($join) use ($deviceId) {
                $join->on('s.id', '=', 'ds.setting_id')
                    ->where('ds.device_id', '=', $deviceId);
            })
            ->get();
    }
}

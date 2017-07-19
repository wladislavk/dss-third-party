<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DB;

class GuideSettingOption extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'option_id', 'setting_id', 'label',
        'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_device_guide_setting_options';

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

    public function getOptionsBySettingIds()
    {
        return $this->select(
                DB::raw('setting_id as id'),
                DB::raw('GROUP_CONCAT(label ORDER BY option_id) as labels'),
                'name',
                'setting_type',
                DB::raw('options as number')
            )->from(DB::raw('dental_device_guide_setting_options o'))
            ->join(DB::raw('dental_device_guide_settings s'), 's.id', '=', 'o.setting_id')
            ->groupBy('setting_id')
            ->orderBy('rank')
            ->get();
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\GuideSettingOption as Resource;
use DentalSleepSolutions\Contracts\Repositories\GuideSettingOptions as Repository;
use DB;

/**
 * @SWG\Definition(
 *     definition="GuideSettingOption",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="option", type="integer"),
 *     @SWG\Property(property="setting", type="integer"),
 *     @SWG\Property(property="label", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\GuideSettingOption
 *
 * @property int $id
 * @property int|null $option_id
 * @property int|null $setting_id
 * @property string|null $label
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereSettingId($value)
 * @mixin \Eloquent
 */
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

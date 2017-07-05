<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\GuideSetting as Resource;
use DentalSleepSolutions\Contracts\Repositories\GuideSettings as Repository;
use DB;

/**
 * @SWG\Definition(
 *     definition="GuideSetting",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="setting_type", type="integer"),
 *     @SWG\Property(property="range_start", type="integer"),
 *     @SWG\Property(property="range_end", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="rank", type="integer"),
 *     @SWG\Property(property="range_start_label", type="string"),
 *     @SWG\Property(property="range_end_label", type="string"),
 *     @SWG\Property(property="options", type="array", @SWG\Items(ref="#/definitions/GuideSettingOption")),
 *     @SWG\Property(property="deviceSettings", type="array", @SWG\Items(ref="#/definitions/GuideDeviceSetting"))
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\GuideSetting
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $setting_type
 * @property int|null $range_start
 * @property int|null $range_end
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $rank
 * @property string|null $range_start_label
 * @property string|null $range_end_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption[] $options
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting[] $deviceSettings
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeEndLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeStartLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereSettingType($value)
 * @mixin \Eloquent
 */
class GuideSetting extends AbstractModel implements Resource, Repository
{
    // @todo: check why $options is not marked as @property-read on generation

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

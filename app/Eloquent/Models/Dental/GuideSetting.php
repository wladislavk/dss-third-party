<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption[] $options
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Models\Dental\GuideDeviceSetting[] $deviceSettings
 * @mixin \Eloquent
 */
class GuideSetting extends AbstractModel
{
    // @todo: check why $options is not marked as @property-read on generation

    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'setting_type',
        'range_start',
        'range_end',
        'adddate',
        'ip_address',
        'rank',
        'options',
        'range_start_label',
        'range_end_label',
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

    const CREATED_AT = 'adddate';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(GuideSettingOption::class, 'setting_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deviceSettings()
    {
        return $this->hasMany(GuideDeviceSetting::class, 'id', 'setting_id');
    }
}

<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="NasalPassage",
 *     type="object",
 *     required={"nasal_passagesid", "ip_address"},
 *     @SWG\Property(property="nasal_passagesid", type="integer"),
 *     @SWG\Property(property="nasal_passages", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage
 *
 * @property int $nasal_passagesid
 * @property string|null $nasal_passages
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage whereNasalPassages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage whereNasalPassagesid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage whereStatus($value)
 */
class NasalPassage extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['nasal_passagesid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_nasal_passages';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'nasal_passagesid';

    const CREATED_AT = 'adddate';
}

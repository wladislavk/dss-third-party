<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="PlanText",
 *     type="object",
 *     required={"plan_textid"},
 *     @SWG\Property(property="plan_textid", type="integer"),
 *     @SWG\Property(property="plan_text", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\PlanText
 *
 * @property int $plan_textid
 * @property string|null $plan_text
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\PlanText whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\PlanText whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\PlanText wherePlanText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\PlanText wherePlanTextid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\PlanText whereStatus($value)
 */
class PlanText extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['plan_textid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_plan_text';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'plan_textid';

    const CREATED_AT = 'adddate';
}

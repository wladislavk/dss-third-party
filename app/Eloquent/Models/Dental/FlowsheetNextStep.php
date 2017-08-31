<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="FlowsheetNextStep",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="parent_id", type="integer"),
 *     @SWG\Property(property="child_id", type="integer"),
 *     @SWG\Property(property="sort_by", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $child_id
 * @property int|null $sort_by
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep whereChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep whereSortBy($value)
 */
class FlowsheetNextStep extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_flowsheet_steps_next';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';
}

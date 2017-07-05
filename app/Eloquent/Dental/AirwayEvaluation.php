<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\AirwayEvaluation as Resource;
use DentalSleepSolutions\Contracts\Repositories\AirwayEvaluations as Repository;

/**
 * DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation
 *
 * @property int $ex_page3id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $maxilla
 * @property string|null $other_maxilla
 * @property string|null $mandible
 * @property string|null $other_mandible
 * @property string|null $soft_palate
 * @property string|null $other_soft_palate
 * @property string|null $uvula
 * @property string|null $other_uvula
 * @property string|null $gag_reflex
 * @property string|null $other_gag_reflex
 * @property string|null $nasal_passages
 * @property string|null $other_nasal_passages
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereExPage3id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereGagReflex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereMandible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereMaxilla($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereNasalPassages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherGagReflex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherMandible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherMaxilla($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherNasalPassages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherSoftPalate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherUvula($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereSoftPalate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereUvula($value)
 * @mixin \Eloquent
 */
class AirwayEvaluation extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid', 'patientid', 'maxilla', 'other_maxilla',
        'mandible', 'other_mandible', 'soft_palate', 'other_soft_palate',
        'uvula', 'other_uvula', 'gag_reflex', 'other_gag_reflex',
        'nasal_passages', 'other_nasal_passages', 'userid',
        'docid', 'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page3';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page3id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

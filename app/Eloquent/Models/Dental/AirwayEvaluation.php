<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="AirwayEvaluation",
 *     type="object",
 *     required={"ex_page3id"},
 *     @SWG\Property(property="ex_page3id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="maxilla", type="string"),
 *     @SWG\Property(property="other_maxilla", type="string"),
 *     @SWG\Property(property="mandible", type="string"),
 *     @SWG\Property(property="other_mandible", type="string"),
 *     @SWG\Property(property="soft_palate", type="string"),
 *     @SWG\Property(property="other_soft_palate", type="string"),
 *     @SWG\Property(property="uvula", type="string"),
 *     @SWG\Property(property="other_uvula", type="string"),
 *     @SWG\Property(property="gag_reflex", type="string"),
 *     @SWG\Property(property="other_gag_reflex", type="string"),
 *     @SWG\Property(property="nasal_passages", type="string"),
 *     @SWG\Property(property="other_nasal_passages", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
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
 * @mixin \Eloquent
 */
class AirwayEvaluation extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid',
        'patientid',
        'maxilla',
        'other_maxilla',
        'mandible',
        'other_mandible',
        'soft_palate',
        'other_soft_palate',
        'uvula',
        'other_uvula',
        'gag_reflex',
        'other_gag_reflex',
        'nasal_passages',
        'other_nasal_passages',
        'userid',
        'docid',
        'status',
        'adddate',
        'ip_address',
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

    const CREATED_AT = 'adddate';
}

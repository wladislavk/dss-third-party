<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\InsuranceDiagnosis as Resource;
use DentalSleepSolutions\Contracts\Repositories\InsuranceDiagnoses as Repository;

/**
 * @SWG\Definition(
 *     definition="InsuranceDiagnosis",
 *     type="object",
 *     required={"ins", "ip"},
 *     @SWG\Property(property="ins", type="integer"),
 *     @SWG\Property(property="ins", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis
 *
 * @property int $ins_diagnosisid
 * @property string|null $ins_diagnosis
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis whereInsDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis whereInsDiagnosisid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis whereStatus($value)
 * @mixin \Eloquent
 */
class InsuranceDiagnosis extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ins_diagnosis', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ins_diagnosis';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'ins_diagnosisid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

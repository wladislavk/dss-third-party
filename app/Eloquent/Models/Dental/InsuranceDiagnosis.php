<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="InsuranceDiagnosis",
 *     type="object",
 *     required={"ins_diagnosisid", "ip_address"},
 *     @SWG\Property(property="ins_diagnosisid", type="integer"),
 *     @SWG\Property(property="ins_diagnosis", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
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
 * @mixin \Eloquent
 */
class InsuranceDiagnosis extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ins_diagnosis',
        'description',
        'sortby',
        'status',
        'adddate',
        'ip_address',
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

    const CREATED_AT = 'adddate';
}

<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="SleepTest",
 *     type="object",
 *     required={"q_sleepid"},
 *     @SWG\Property(property="q_sleepid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="epworthid", type="string"),
 *     @SWG\Property(property="analysis", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="parent_patientid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\SleepTest
 *
 * @property int $q_sleepid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $epworthid
 * @property string|null $analysis
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $parent_patientid
 * @mixin \Eloquent
 */
class SleepTest extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_sleepid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_sleep';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_sleepid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

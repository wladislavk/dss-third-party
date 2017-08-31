<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="MissingTooth",
 *     type="object",
 *     required={"missingid"},
 *     @SWG\Property(property="missingid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="pck", type="string"),
 *     @SWG\Property(property="rec", type="string"),
 *     @SWG\Property(property="mob", type="string"),
 *     @SWG\Property(property="rec1", type="string"),
 *     @SWG\Property(property="pck1", type="string"),
 *     @SWG\Property(property="s1", type="string"),
 *     @SWG\Property(property="s2", type="string"),
 *     @SWG\Property(property="s3", type="string"),
 *     @SWG\Property(property="s4", type="string"),
 *     @SWG\Property(property="s5", type="string"),
 *     @SWG\Property(property="s6", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth
 *
 * @property int $missingid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $pck
 * @property string|null $rec
 * @property string|null $mob
 * @property string|null $rec1
 * @property string|null $pck1
 * @property string|null $s1
 * @property string|null $s2
 * @property string|null $s3
 * @property string|null $s4
 * @property string|null $s5
 * @property string|null $s6
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereMissingid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereMob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth wherePck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth wherePck1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereRec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereRec1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereS3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereS4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereS5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereS6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth whereUserid($value)
 */
class MissingTooth extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['missingid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_missing';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'missingid';

    const CREATED_AT = 'adddate';

    public function getPlural()
    {
        return 'MissingTeeth';
    }
}

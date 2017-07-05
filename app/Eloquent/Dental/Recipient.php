<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Recipient as Resource;
use DentalSleepSolutions\Contracts\Repositories\Recipients as Repository;

/**
 * @SWG\Definition(
 *     definition="Recipient",
 *     type="object",
 *     required={"q"},
 *     @SWG\Property(property="q", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="referring", type="string"),
 *     @SWG\Property(property="dentist", type="string"),
 *     @SWG\Property(property="physicians", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string"),
 *     @SWG\Property(property="q", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Recipient
 *
 * @property int $q_recipientsid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $referring_physician
 * @property string|null $dentist
 * @property string|null $physicians_other
 * @property string|null $patient_info
 * @property string|null $q_file1
 * @property string|null $q_file2
 * @property string|null $q_file3
 * @property string|null $q_file4
 * @property string|null $q_file5
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $q_file6
 * @property string|null $q_file7
 * @property string|null $q_file8
 * @property string|null $q_file9
 * @property string|null $q_file10
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereDentist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient wherePatientInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient wherePhysiciansOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQRecipientsid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereReferringPhysician($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereUserid($value)
 * @mixin \Eloquent
 */
class Recipient extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_recipientsid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_recipients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_recipientsid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

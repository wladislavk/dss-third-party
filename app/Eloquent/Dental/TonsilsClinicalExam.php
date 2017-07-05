<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\TonsilsClinicalExam as Resource;
use DentalSleepSolutions\Contracts\Repositories\TonsilsClinicalExams as Repository;

/**
 * @SWG\Definition(
 *     definition="TonsilsClinicalExam",
 *     type="object",
 *     required={"ex"},
 *     @SWG\Property(property="ex", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="mallampati", type="string"),
 *     @SWG\Property(property="tonsils", type="string"),
 *     @SWG\Property(property="tonsils", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="additional", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam
 *
 * @property int $ex_page2id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $mallampati
 * @property string|null $tonsils
 * @property string|null $tonsils_grade
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $additional_notes
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereAdditionalNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereExPage2id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereMallampati($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereTonsils($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereTonsilsGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereUserid($value)
 * @mixin \Eloquent
 */
class TonsilsClinicalExam extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid', 'patientid', 'mallampati', 'tonsils',
        'tonsils_grade', 'userid', 'docid', 'status',
        'adddate', 'ip_address', 'additional_notes'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page2';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page2id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

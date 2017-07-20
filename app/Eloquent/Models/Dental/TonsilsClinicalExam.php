<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="TonsilsClinicalExam",
 *     type="object",
 *     required={"ex_page2id"},
 *     @SWG\Property(property="ex_page2id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="mallampati", type="string"),
 *     @SWG\Property(property="tonsils", type="string"),
 *     @SWG\Property(property="tonsils_grade", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="additional_notes", type="string")
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
 * @mixin \Eloquent
 */
class TonsilsClinicalExam extends AbstractModel
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

<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="Recipient",
 *     type="object",
 *     required={"q_recipientsid"},
 *     @SWG\Property(property="q_recipientsid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="referring_physician", type="string"),
 *     @SWG\Property(property="dentist", type="string"),
 *     @SWG\Property(property="physicians_other", type="string"),
 *     @SWG\Property(property="patient_info", type="string"),
 *     @SWG\Property(property="q_file1", type="string"),
 *     @SWG\Property(property="q_file2", type="string"),
 *     @SWG\Property(property="q_file3", type="string"),
 *     @SWG\Property(property="q_file4", type="string"),
 *     @SWG\Property(property="q_file5", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="q_file6", type="string"),
 *     @SWG\Property(property="q_file7", type="string"),
 *     @SWG\Property(property="q_file8", type="string"),
 *     @SWG\Property(property="q_file9", type="string"),
 *     @SWG\Property(property="q_file10", type="string")
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
 * @mixin \Eloquent
 */
class Recipient extends AbstractModel implements Resource
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

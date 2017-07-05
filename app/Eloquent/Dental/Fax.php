<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Fax as Resource;
use DentalSleepSolutions\Contracts\Repositories\Faxes as Repository;
use DB;

/**
 * DentalSleepSolutions\Eloquent\Dental\Fax
 *
 * @property int $id
 * @property int|null $patientid
 * @property int|null $userid
 * @property int|null $docid
 * @property \Carbon\Carbon|null $sent_date
 * @property int|null $pages
 * @property int|null $contactid
 * @property string|null $to_number
 * @property string|null $to_name
 * @property int|null $letterid
 * @property string|null $filename
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $fax_invoice_id
 * @property string|null $sfax_transmission_id
 * @property int|null $sfax_completed
 * @property string|null $sfax_response
 * @property int|null $sfax_status
 * @property string|null $sfax_error_code
 * @property string|null $letter_body
 * @property int|null $viewed
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereContactid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereFaxInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereLetterBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereLetterid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax wherePages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxErrorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxTransmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereToName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereToNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereViewed($value)
 * @mixin \Eloquent
 */
class Fax extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'patientid', 'userid', 'docid', 'sent_date', 'pages', 'contactid',
        'to_number', 'to_name', 'letterid', 'filename', 'status', 'adddate',
        'ip_address', 'fax_invoice_id', 'sfax_transmission_id', 'sfax_completed',
        'sfax_response', 'sfax_status', 'sfax_error_code', 'letter_body', 'viewed'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_faxes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['sent_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getAlerts($docId = 0)
    {
        return $this->select(DB::raw('COUNT(id) AS total'))
            ->where('docid', $docId)
            ->whereRaw('COALESCE(viewed, 0) = 0')
            ->where('sfax_status', 2)
            ->first();
    }

    /**
     * @param int $letterId
     * @param array $data
     * @return bool|int
     */
    public function updateByLetterId($letterId, array $data)
    {
        return $this->where('letterid', $letterId)
            ->update($data);
    }
}

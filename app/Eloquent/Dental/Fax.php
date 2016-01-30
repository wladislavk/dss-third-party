<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Fax as Resource;
use DentalSleepSolutions\Contracts\Repositories\Faxes as Repository;

class Fax extends Model implements Resource, Repository
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
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

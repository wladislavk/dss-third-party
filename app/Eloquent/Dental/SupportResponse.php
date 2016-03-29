<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\SupportResponse as Resource;
use DentalSleepSolutions\Contracts\Repositories\SupportResponses as Repository;

class SupportResponse extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id', 'responder_id', 'body', 'response_type',
        'adddate', 'ip_address', 'viewed', 'attachment'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_support_responses';

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

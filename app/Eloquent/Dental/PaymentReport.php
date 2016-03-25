<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\PaymentReport as Resource;
use DentalSleepSolutions\Contracts\Repositories\PaymentReports as Repository;

class PaymentReport extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'claimid', 'reference_id', 'response',
        'adddate', 'ip_address', 'viewed'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_payment_reports';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'payment_id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

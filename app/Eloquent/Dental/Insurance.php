<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Insurance as Resource;
use DentalSleepSolutions\Contracts\Repositories\Insurances as Repository;

class Insurance extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['insuranceid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_insurance';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'insuranceid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['mailed_date', 'sec_mailed_date', 'percase_date'];

    private $claimStatuses = [
        'DSS_CLAIM_PENDING'             => 0,
        'DSS_CLAIM_SENT'                => 1,
        'DSS_CLAIM_DISPUTE'             => 2
        'DSS_CLAIM_PAID_INSURANCE'      => 3
        'DSS_CLAIM_REJECTED'            => 4
        'DSS_CLAIM_PAID_PATIENT'        => 5
        'DSS_CLAIM_SEC_PENDING'         => 6
        'DSS_CLAIM_SEC_SENT'            => 7
        'DSS_CLAIM_SEC_DISPUTE'         => 8
        'DSS_CLAIM_PAID_SEC_INSURANCE'  => 9
        'DSS_CLAIM_PATIENT_DISPUTE'     => 10
        'DSS_CLAIM_PAID_SEC_PATIENT'    => 11
        'DSS_CLAIM_SEC_PATIENT_DISPUTE' => 12
        'DSS_CLAIM_SEC_REJECTED'        => 13
        'DSS_CLAIM_EFILE_ACCEPTED'      => 14
        'DSS_CLAIM_SEC_EFILE_ACCEPTED'  => 15
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeRejected($query)
    {
        return $query->where(function($query) {
            $query->where('status', self::$claimStatuses['DSS_CLAIM_REJECTED'])
                ->orWhere('status', self::$claimStatuses['DSS_CLAIM_SEC_REJECTED']);
        });
    }

    public function getRejected($patientId = 0)
    {
        return $this->rejected
            ->where('patientid', $patientId)
            ->get();
    }
}

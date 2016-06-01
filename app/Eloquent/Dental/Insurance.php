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
        'DSS_CLAIM_DISPUTE'             => 2,
        'DSS_CLAIM_PAID_INSURANCE'      => 3,
        'DSS_CLAIM_REJECTED'            => 4,
        'DSS_CLAIM_PAID_PATIENT'        => 5,
        'DSS_CLAIM_SEC_PENDING'         => 6,
        'DSS_CLAIM_SEC_SENT'            => 7,
        'DSS_CLAIM_SEC_DISPUTE'         => 8,
        'DSS_CLAIM_PAID_SEC_INSURANCE'  => 9,
        'DSS_CLAIM_PATIENT_DISPUTE'     => 10,
        'DSS_CLAIM_PAID_SEC_PATIENT'    => 11,
        'DSS_CLAIM_SEC_PATIENT_DISPUTE' => 12,
        'DSS_CLAIM_SEC_REJECTED'        => 13,
        'DSS_CLAIM_EFILE_ACCEPTED'      => 14,
        'DSS_CLAIM_SEC_EFILE_ACCEPTED'  => 15
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeRejected($globalQuery)
    {
        return $globalQuery->where(function($query) {
            return $query->where('status', $this->claimStatuses['DSS_CLAIM_REJECTED'])
                ->orWhere('status', $this->claimStatuses['DSS_CLAIM_SEC_REJECTED']);
        });
    }

    public function scopeBackOfficeClaimsConditional($query, $aliases = [])
    {
        $actionableStatusList = $db->escapeList(ClaimFormData::statusListByName('actionable'));
        $pendingStatusList = $db->escapeList(ClaimFormData::statusListByName('pending'));

        $claimAlias = $db->escape(array_get($aliases, 'claim', 'claim'));
        $patientAlias = $db->escape(array_get($aliases, 'patient', 'p'));
        $companyAlias = $db->escape(array_get($aliases, 'company', 'c'));

        $filedByBackOfficeConditional = filedByBackOfficeConditional($claimAlias);

        return $query->where(function($query) {
                return $query->whereNotIn("$claimAlias.status", $pendingStatusList)
                    ->where($filedByBackOfficeConditional);
            })
            ->orWhere(function($query) {
                return $query->whereIn("$claimAlias.status", $actionableStatusList)
                    ->where(function($query) {
                        return $query->whereRaw("COALESCE($companyAlias.exclusive, 0)")
                            ->orWhereRaw("COALESCE(IF($claimAlias.primary_claim_id, $patientAlias.s_m_dss_file, $patientAlias.p_m_dss_file), 0) = 1");
                    });
            });
    }

    public function scopeFrontOfficeClaimsConditional($query, $aliases = [])
    {
        return $query->whereNot(function($query) use ($aliases) {
            return $query->backOfficeClaimsConditional($aliases);
        });
    }

    public function scopeFrontofficeClaims($query)
    {
        return $query->from(DB::raw('dental_insurance claim'))
            ->select(DB::raw('COUNT(claim.insuranceid) AS total'))
            ->leftJoin(DB::raw('dental_patients patient'), 'patient.patientid', '=', 'claim.patientid')
            ->join(DB::raw('dental_users users'), 'claim.docid', '=', 'users.userid')
            ->leftJoin(DB::raw('companies company'), 'company.id', '=', 'users.billing_company_id')
            ->frontOfficeClaimsConditional()
    }

    public function getRejected($patientId = 0)
    {
        return $this->rejected()
            ->where('patientid', $patientId)
            ->get();
    }

    public function getPendingClaims()
    {
        return $this->
    }
}

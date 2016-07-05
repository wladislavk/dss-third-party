<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Insurance as Resource;
use DentalSleepSolutions\Contracts\Repositories\Insurances as Repository;
use DentalSleepSolutions\Libraries\ClaimFormData;
use DB;

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

    private function filedByBackOfficeConditional($claimAlias = 'claim')
    {
        return "(
                -- Filed by back office, legacy logic
                COALESCE(IF($claimAlias.primary_claim_id, $claimAlias.s_m_dss_file, $claimAlias.p_m_dss_file), 0) = 1
                -- Filed by back office, new logic
                OR COALESCE($claimAlias.p_m_dss_file, 0) = 3
            )";
    }

    private function backOfficeClaimsConditional($aliases = [])
    {
        $actionableStatusList = "'" . implode("', '", ClaimFormData::statusListByName('actionable')) . "'";
        $pendingStatusList    = "'" . implode("', '", ClaimFormData::statusListByName('pending')) . "'";

        $claimAlias   = array_get($aliases, 'claim', 'claim');
        $patientAlias = array_get($aliases, 'patient', 'p');
        $companyAlias = array_get($aliases, 'company', 'c');

        $filedByBackOfficeConditional = $this->filedByBackOfficeConditional($claimAlias);

        return "(
            -- Apply claim options only if the status is NOT pending
            (
                $claimAlias.status NOT IN ($pendingStatusList)
                AND $filedByBackOfficeConditional
            )
            OR (
                $claimAlias.status IN ($actionableStatusList)
                AND (
                    -- Doctor BO exclusivity
                    COALESCE($companyAlias.exclusive, 0)
                    -- Patient's BO filing permission
                    OR COALESCE(IF($claimAlias.primary_claim_id, $patientAlias.s_m_dss_file, $patientAlias.p_m_dss_file), 0) = 1
                )
            )
        )";
    }

    private function frontOfficeClaimsConditional($aliases = [])
    {
        return '(NOT ' . $this->backOfficeClaimsConditional($aliases) . ')';
    }

    public function scopeRejected($globalQuery)
    {
        return $globalQuery->where(function($query) {
            return $query->where('status', $this->claimStatuses['DSS_CLAIM_REJECTED'])
                ->orWhere('status', $this->claimStatuses['DSS_CLAIM_SEC_REJECTED']);
        });
    }

    public function scopeFiledByBackOfficeConditional($query, $claimAlias='claim')
    {
        // Filed by back office, legacy logic
        return $query->whereRaw("COALESCE(IF($claimAlias.primary_claim_id, $claimAlias.s_m_dss_file, $claimAlias.p_m_dss_file), 0) = 1")
            // Filed by back office, new logic
            ->orWhereRaw("COALESCE($claimAlias.p_m_dss_file, 0) = 3");
    }

    public function scopeCountFrontOfficeClaims($query, $docId = 0)
    {
        return $query->from(DB::raw('dental_insurance claim'))
            ->select(DB::raw('COUNT(claim.insuranceid) AS total'))
            ->leftJoin(DB::raw('dental_patients patient'), 'patient.patientid', '=', 'claim.patientid')
            ->join(DB::raw('dental_users users'), 'claim.docid', '=', 'users.userid')
            ->leftJoin(DB::raw('companies company'), 'company.id', '=', 'users.billing_company_id')
            ->whereRaw($this->frontOfficeClaimsConditional(['company' => 'company', 'patient' => 'patient']))
            ->where('claim.docid', $docId);
    }

    public function getRejected($patientId = 0)
    {
        return $this->rejected()
            ->where('patientid', $patientId)
            ->get();
    }

    public function getPendingClaims($docId = 0)
    {
        return $this->countFrontOfficeClaims($docId)
            ->whereIn('claim.status', ClaimFormData::statusListByName('actionable'))
            ->first();
    }

    public function getUnmailedClaims($docId = 0)
    {
        return $this->countFrontOfficeClaims($docId)
            ->whereNull('claim.mailed_date')
            ->whereNull('claim.sec_mailed_date')
            ->whereNotIn('claim.status', ClaimFormData::statusListByName('pending'))
            ->first();
    }

    public function getRejectedClaims($docId = 0)
    {
        return $this->countFrontOfficeClaims($docId)
            ->whereIn('claim.status', ClaimFormData::statusListByName('rejected'))
            ->first();
    }
}

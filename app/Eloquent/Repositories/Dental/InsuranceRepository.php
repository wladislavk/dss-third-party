<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Libraries\ClaimFormData;
use DentalSleepSolutions\Structs\LedgerReportData;
use Illuminate\Database\Eloquent\Builder;

class InsuranceRepository extends AbstractRepository
{
    /** @var Insurance|Builder */
    protected $model;

    public function model()
    {
        return Insurance::class;
    }

    /**
     * @param int $patientId
     * @return Insurance[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRejected($patientId)
    {
        return $this->model
            ->where(function (Builder $query) {
                return $query->where('status', Insurance::DSS_CLAIM_REJECTED)
                    ->orWhere('status', Insurance::DSS_CLAIM_SEC_REJECTED);
            })
            ->where('patientid', $patientId)
            ->get();
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function getPendingClaims($docId)
    {
        return $this->model
            ->from(\DB::raw('dental_insurance claim'))
            ->select(\DB::raw('COUNT(claim.insuranceid) AS total'))
            ->leftJoin(\DB::raw('dental_patients patient'), 'patient.patientid', '=', 'claim.patientid')
            ->join(\DB::raw('dental_users users'), 'claim.docid', '=', 'users.userid')
            ->leftJoin(\DB::raw('companies company'), 'company.id', '=', 'users.billing_company_id')
            ->whereRaw($this->frontOfficeClaimsConditional(['company' => 'company', 'patient' => 'patient']))
            ->where('claim.docid', $docId)
            ->whereIn('claim.status', ClaimFormData::statusListByName('actionable'))
            ->first();
    }

    /**
     * @param int $docId
     * @param bool $isUserTypeSoftware
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function getUnmailedClaims($docId, $isUserTypeSoftware = false)
    {
        $query = $this->model
            ->from(\DB::raw('dental_insurance claim'))
            ->select(\DB::raw('COUNT(claim.insuranceid) AS total'))
            ->leftJoin(\DB::raw('dental_patients patient'), 'patient.patientid', '=', 'claim.patientid')
            ->join(\DB::raw('dental_users users'), 'claim.docid', '=', 'users.userid')
            ->leftJoin(\DB::raw('companies company'), 'company.id', '=', 'users.billing_company_id')
            ->whereRaw($this->frontOfficeClaimsConditional(['company' => 'company', 'patient' => 'patient']))
            ->where('claim.docid', $docId)
            ->whereNull('claim.mailed_date')
            ->whereNull('claim.sec_mailed_date')
        ;

        if ($isUserTypeSoftware) {
            $query = $query->whereNotIn('claim.status', ClaimFormData::statusListByName('actionable'));
        }

        return $query->first();
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function getRejectedClaims($docId)
    {
        return $this->model
            ->from(\DB::raw('dental_insurance claim'))
            ->select(\DB::raw('COUNT(claim.insuranceid) AS total'))
            ->leftJoin(\DB::raw('dental_patients patient'), 'patient.patientid', '=', 'claim.patientid')
            ->join(\DB::raw('dental_users users'), 'claim.docid', '=', 'users.userid')
            ->leftJoin(\DB::raw('companies company'), 'company.id', '=', 'users.billing_company_id')
            ->whereRaw($this->frontOfficeClaimsConditional(['company' => 'company', 'patient' => 'patient']))
            ->where('claim.docid', $docId)
            ->whereIn('claim.status', ClaimFormData::statusListByName('rejected'))
            ->first();
    }

    /**
     * @param int $claimId
     * @return bool|int|null
     */
    public function removePendingClaim($claimId)
    {
        return $this->model
            ->where('insuranceid', $claimId)
            ->where('status', Insurance::DSS_CLAIM_PENDING)
            ->delete();
    }

    /**
     * @param LedgerReportData $data
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getOpenClaims(LedgerReportData $data)
    {
        $query = $this->model->select(
            'i.patientid',
            'i.docid',
            \DB::raw("'claim'"),
            'i.insuranceid AS ledgerid',
            'i.adddate AS service_date',
            'i.adddate AS entry_date',
            \DB::raw("'Claim' AS name"),
            \DB::raw("'Insurance Claim' AS description"),
            \DB::raw('(
                            SELECT SUM(dl2.amount)
                            FROM dental_ledger dl2
                                INNER JOIN dental_insurance i2 ON dl2.primary_claim_id = i2.insuranceid
                            WHERE i2.insuranceid = i.insuranceid
                        ) AS amount'),
            \DB::raw('SUM(pay.amount) AS paid_amount'),
            'i.status',
            'i.insuranceid AS primary_claim_id',
            'i.mailed_date',
            \DB::raw($this->filedByBackOfficeConditional('i') . ' as filed_by_bo')
        )->from(\DB::raw('dental_insurance i'))
            ->leftJoin(\DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->where('i.patientid', $data->patientId)
            ->whereNotIn('i.status', [
                Insurance::DSS_CLAIM_PAID_INSURANCE,
                Insurance::DSS_CLAIM_PAID_SEC_INSURANCE,
                Insurance::DSS_CLAIM_PAID_PATIENT,
            ])->groupBy('i.insuranceid')
            ->orderBy($this->getSortColumnForList($data->sort), $data->sortDir)
            ->skip($data->page * $data->rowsPerPage)
            ->take($data->rowsPerPage);

        return $query->get();
    }

    /**
     * @param string $claimAlias
     * @return string
     */
    public static function filedByBackOfficeConditional($claimAlias)
    {
        return "(
                -- Filed by back office, legacy logic
                COALESCE(IF($claimAlias.primary_claim_id, $claimAlias.s_m_dss_file, $claimAlias.p_m_dss_file), 0) = 1
                -- Filed by back office, new logic
                OR COALESCE($claimAlias.p_m_dss_file, 0) = 3
            )";
    }

    /**
     * @param string $sort
     * @return string
     */
    private function getSortColumnForList($sort)
    {
        $sortColumns = [
            'entry_date'  => 'entry_date',
            'producer'    => 'name',
            'patient'     => 'lastname',
            'description' => 'description',
            'amount'      => 'amount',
            'paid_amount' => 'paid_amount',
            'status'      => 'status',
        ];

        $sortColumn = 'service_date';
        if (array_key_exists($sort, $sortColumns)) {
            $sortColumn = $sortColumns[$sort];
        }

        return $sortColumn;
    }

    /**
     * @param array $aliases
     * @return string
     */
    private function frontOfficeClaimsConditional(array $aliases = [])
    {
        return '(NOT ' . $this->backOfficeClaimsConditional($aliases) . ')';
    }

    /**
     * @param array $aliases
     * @return string
     */
    private function backOfficeClaimsConditional(array $aliases = [])
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
}

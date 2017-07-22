<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Libraries\ClaimFormData;
use Illuminate\Database\Query\Builder;

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
        return $this->model->rejected()->where('patientid', $patientId)->get();
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function getPendingClaims($docId)
    {
        return $this->countFrontOfficeClaims($docId)
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
        $query = $this->countFrontOfficeClaims($docId)
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
        return $this->countFrontOfficeClaims($docId)
            ->whereIn('claim.status', ClaimFormData::statusListByName('rejected'))
            ->first();
    }

    /**
     * @param int $claimId
     * @return bool|int|null
     */
    public function removePendingClaim($claimId)
    {
        return $this->model->where('insuranceid', $claimId)->pending()->delete();
    }

    /**
     * @param int $docId
     * @return Builder
     */
    private function countFrontOfficeClaims($docId)
    {
        return $this->model->countFrontOfficeClaims($docId);
    }

    /**
     * @param int $patientId
     * @param int $page
     * @param int $rowsPerPage
     * @param string $sort
     * @param string $sortDir
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getOpenClaims($patientId, $page, $rowsPerPage, $sort, $sortDir)
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
            \DB::raw($this->model->filedByBackOfficeConditional('i') . ' as filed_by_bo')
        )->from(\DB::raw('dental_insurance i'))
            ->leftJoin(\DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->where('i.patientid', $patientId)
            ->whereNotIn('i.status', [
                Insurance::DSS_CLAIM_PAID_INSURANCE,
                Insurance::DSS_CLAIM_PAID_SEC_INSURANCE,
                Insurance::DSS_CLAIM_PAID_PATIENT,
            ])->groupBy('i.insuranceid')
            ->orderBy($this->getSortColumnForList($sort), $sortDir)
            ->skip($page * $rowsPerPage)
            ->take($rowsPerPage);

        return $query->get();
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
}

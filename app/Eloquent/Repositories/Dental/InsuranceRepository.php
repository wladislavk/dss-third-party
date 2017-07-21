<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Libraries\ClaimFormData;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceRepository extends BaseRepository
{
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
}

<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Structs\ListVOBQueryData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

class InsurancePreauthRepository extends AbstractRepository
{
    const REJECT_REASON = '%s altered patient insurance information requiring VOB resubmission on %s';

    const COLUMN_CHANGE_RULES = [
        'request_date' => 'preauth.front_office_request_date',
        'patient_name' => 'p.lastname',
        'status' => 'preauth.status',
    ];

    const VOB_QUERY_FIELDS = [
        'preauth.id',
        'p.firstname',
        'p.lastname',
        'preauth.viewed',
        'preauth.front_office_request_date',
        'preauth.patient_id',
        'preauth.status',
        'preauth.reject_reason',
    ];


    public function model()
    {
        return InsurancePreauth::class;
    }

    /**
     * @param int $docId
     * @return InsurancePreauth|Model|null
     */
    public function getCompleted($docId)
    {
        return $this
            ->basedPreauth($docId)
            ->where('status', InsurancePreauth::DSS_PREAUTH_COMPLETE)
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return InsurancePreauth|Model|null
     */
    public function getPending($docId)
    {
        return $this
            ->basedPreauth($docId)
            ->where('status', InsurancePreauth::DSS_PREAUTH_PENDING)
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return InsurancePreauth|Model|null
     */
    public function getRejected($docId)
    {
        return $this
            ->basedPreauth($docId)
            ->where('status', InsurancePreauth::DSS_PREAUTH_REJECTED)
            ->first()
        ;
    }

    /**
     * @param $docId
     * @return Builder
     */
    private function basedPreauth($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(id) AS total'))
            ->where('doc_id', $docId)
            ->whereRaw('COALESCE(viewed, 0) != 1')
        ;
    }

    /**
     * @param int $contactId
     * @return Model|null
     */
    public function getPendingVOBByContactId($contactId)
    {
        return $this->model
            ->select('ip.*')
            ->from(\DB::raw('dental_insurance_preauth ip'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'ip.patient_id')
            ->where(function (Builder $query) use ($contactId) {
                $query
                    ->where(function (Builder $query) use ($contactId) {
                        $query
                            ->where('p.p_m_ins_co', '=', $contactId)
                            ->orWhere('p.s_m_ins_co', '=', $contactId)
                        ;
                    })
                    ->where(function (Builder $query) {
                        $query
                            ->where('ip.status', '=', InsurancePreauth::DSS_PREAUTH_PENDING)
                            ->orWhere('ip.status', '=', InsurancePreauth::DSS_PREAUTH_PREAUTH_PENDING)
                        ;
                    })
                ;
            })
            ->orderBy('ip.front_office_request_date', 'desc')
            ->first()
        ;
    }

    /**
     * @param ListVOBQueryData $data
     * @return Builder|QueryBuilder
     */
    public function getListVobsBaseQuery(ListVOBQueryData $data) {
        $query = $this->model
            ->select(\DB::raw(join(', ', self::VOB_QUERY_FIELDS)))
            ->from(\DB::raw('dental_insurance_preauth preauth'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'preauth.patient_id')
            ->where('preauth.doc_id', '=', $data->docId)
        ;

        return $query;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder|QueryBuilder
     */
    public function getListVobsSetPreauthViewedWithViewed($query)
    {
        return $query->where('preauth.viewed', 1);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param string $sortColumn
     * @param string $sortDir
     * @return Builder|QueryBuilder
     */
    public function getListVobsSetOrderBy($query, $sortColumn, $sortDir)
    {
        return $query->orderBy($sortColumn, $sortDir);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder|QueryBuilder
     */
    public function getListVobsSetPreauthViewedWithoutViewed($query)
    {
        return $query->where(function (QueryBuilder $query) {
            $query
                ->where('preauth.viewed', '=', 0)
                ->orWhereNull('preauth.viewed')
            ;
        });
    }

    /**
     * @param int $newPatientId
     * @param string $name
     * @return bool|int
     */
    public function updateVob($newPatientId, $name)
    {
        $formattedDate = Carbon::now()->format('m/d/Y h:i');
        $rejectReason = sprintf(self::REJECT_REASON, $name, $formattedDate);

        return $this->model
            ->where('patient_id', $newPatientId)
            ->where(function (Builder $query) {
                $query
                    ->where('status', '=', InsurancePreauth::DSS_PREAUTH_PENDING)
                    ->orWhere('status', '=', InsurancePreauth::DSS_PREAUTH_PREAUTH_PENDING)
                ;
            })
            ->update([
                'status'        => InsurancePreauth::DSS_PREAUTH_REJECTED,
                'reject_reason' => $rejectReason,
                'viewed'        => 1,
            ])
        ;
    }

    /**
     * @param int $patientId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getPendingVob($patientId)
    {
        return $this->model
            ->where('patient_id', $patientId)
            ->where(function (Builder $query) {
                $query
                    ->where('status', '=', InsurancePreauth::DSS_PREAUTH_PENDING)
                    ->orWhere('status', '=', InsurancePreauth::DSS_PREAUTH_PREAUTH_PENDING)
                ;
            })
            ->orderBy('front_office_request_date', 'desc')
            ->first()
        ;
    }
}

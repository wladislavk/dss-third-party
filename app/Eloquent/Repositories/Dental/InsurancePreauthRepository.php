<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

class InsurancePreauthRepository extends AbstractRepository
{
    const REJECT_REASON = '%s altered patient insurance information requiring VOB resubmission on %s';

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
     * @param int $docId
     * @param string $sortColumn
     * @param string $sortDir
     * @param int $vobsPerPage
     * @param int $offset
     * @param bool|null $viewed
     * @return array
     */
    public function getListVobs(
        $docId,
        $sortColumn,
        $sortDir,
        $vobsPerPage,
        $offset,
        $viewed
    ) {
        $newSortColumn = $this->changeSortColumn($sortColumn);

        $selected = [
            'preauth.id',
            'p.firstname',
            'p.lastname',
            'preauth.viewed',
            'preauth.front_office_request_date',
            'preauth.patient_id',
            'preauth.status',
            'preauth.reject_reason',
        ];
        /** @var Builder|QueryBuilder $query */
        $query = $this->model
            ->select(\DB::raw(join(', ', $selected)))
            ->from(\DB::raw('dental_insurance_preauth preauth'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'preauth.patient_id')
            ->where('preauth.doc_id', '=', $docId)
        ;

        if ($viewed !== null) {
            $query = $this->setPreauthViewed($query, $viewed);
        }

        $query = $query->orderBy($newSortColumn, $sortDir);

        return [
            'total'  => $query->get()->count(),
            'result' => $query->skip($offset)->take($vobsPerPage)->get(),
        ];
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param bool $viewed
     * @return Builder|QueryBuilder
     */
    private function setPreauthViewed($query, $viewed)
    {
        if ($viewed) {
            return $query->where('preauth.viewed', 1);
        }
        return $query->where(function (QueryBuilder $query) {
            $query
                ->where('preauth.viewed', '=', 0)
                ->orWhereNull('preauth.viewed')
            ;
        });
    }

    /**
     * @param string $sortColumn
     * @return string
     */
    private function changeSortColumn($sortColumn)
    {
        $columnChangeRules = [
            'request_date' => 'preauth.front_office_request_date',
            'patient_name' => 'p.lastname',
            'status' => 'preauth.status',
        ];

        if (isset($columnChangeRules[$sortColumn])) {
            return $columnChangeRules[$sortColumn];
        }

        return $sortColumn;
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

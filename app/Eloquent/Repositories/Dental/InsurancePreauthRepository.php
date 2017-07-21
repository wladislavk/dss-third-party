<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;

class InsurancePreauthRepository extends BaseRepository
{
    public function model()
    {
        return InsurancePreauth::class;
    }

    /**
     * @param int $docId
     * @return InsurancePreauth|null
     */
    public function getCompleted($docId)
    {
        return $this->basedPreauth($docId)->completed()->first();
    }

    /**
     * @param int $docId
     * @return InsurancePreauth|null
     */
    public function getPending($docId)
    {
        return $this->basedPreauth($docId)->pending()->first();
    }

    /**
     * @param int $docId
     * @return InsurancePreauth|null
     */
    public function getRejected($docId)
    {
        return $this->basedPreauth($docId)->rejected()->first();
    }

    /**
     * @param $docId
     * @return Builder
     */
    private function basedPreauth($docId)
    {
        return $this->model->basedPreauth($docId);
    }

    /**
     * @param int $contactId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getPendingVOBByContactId($contactId)
    {
        return $this->model->select('ip.*')
            ->from(\DB::raw('dental_insurance_preauth ip'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'ip.patient_id')
            ->where(function($query) use ($contactId) {
                $query->where(function($query) use ($contactId) {
                    $query->where('p.p_m_ins_co', '=', $contactId)
                        ->orWhere('p.s_m_ins_co', '=', $contactId);
                })->where(function($query) {
                    $query->where('ip.status', '=', InsurancePreauth::DSS_PREAUTH_PENDING)
                        ->orWhere('ip.status', '=', InsurancePreauth::DSS_PREAUTH_PREAUTH_PENDING);
                });
            })->orderBy('ip.front_office_request_date', 'desc')
            ->first();
    }

    /**
     * @param int $docId
     * @param string $sortColumn
     * @param string $sortDir
     * @param int $vobsPerPage
     * @param int $pageNumber
     * @param int|null $viewed
     * @return array
     */
    public function getListVobs(
        $docId,
        $sortColumn,
        $sortDir,
        $vobsPerPage,
        $pageNumber,
        $viewed = null
    ) {
        $offset = $vobsPerPage * $pageNumber;

        switch ($sortColumn) {
            case 'request_date':
                $sortColumn = 'preauth.front_office_request_date';
                break;
            case 'patient_name':
                $sortColumn = 'p.lastname';
                break;
            case 'status':
                $sortColumn = 'preauth.status';
                break;
            default:
                break;
        }

        $query = $this->model->select(\DB::raw('
                preauth.id,
                p.firstname,
                p.lastname,
                preauth.viewed,
                preauth.front_office_request_date,
                preauth.patient_id,
                preauth.status,
                preauth.reject_reason
            '))
            ->from(\DB::raw('dental_insurance_preauth preauth'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'preauth.patient_id')
            ->where('preauth.doc_id', '=', $docId);

        if ($viewed !== null) {
            if ($viewed == 1) {
                $query = $query->where('preauth.viewed', $viewed);
            } else {
                $query = $query->where(function($query) {
                    $query->where('preauth.viewed', '=', 0)
                        ->orWhereNull('preauth.viewed');
                });
            }
        }

        $query = $query->orderBy($sortColumn, $sortDir);

        return [
            'total'  => $query->get()->count(),
            'result' => $query->skip($offset)->take($vobsPerPage)->get(),
        ];
    }

    /**
     * @param int $newPatientId
     * @param string $name
     * @return bool|int
     */
    public function updateVob($newPatientId, $name)
    {
        $rejectReason = $name . ' altered patient insurance information requiring VOB resubmission on ' . Carbon::now()->format('m/d/Y h:i');

        return $this->model->where('patient_id', $newPatientId)
            ->where(function($query) {
                $query
                    ->where('status', '=', InsurancePreauth::DSS_PREAUTH_PENDING)
                    ->orWhere('status', '=', InsurancePreauth::DSS_PREAUTH_PREAUTH_PENDING)
                ;
            })
            ->update([
                'status'        => InsurancePreauth::DSS_PREAUTH_REJECTED,
                'reject_reason' => $rejectReason,
                'viewed'        => 1,
            ]);
    }

    /**
     * @param int $patientId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getPendingVob($patientId)
    {
        return $this->model->where('patient_id', $patientId)
            ->where(function($query) {
                $query
                    ->where('status', '=', InsurancePreauth::DSS_PREAUTH_PENDING)
                    ->orWhere('status', '=', InsurancePreauth::DSS_PREAUTH_PREAUTH_PENDING)
                ;
            })
            ->orderBy('front_office_request_date', 'desc')
            ->first();
    }
}

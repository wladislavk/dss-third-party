<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth as Resource;
use DentalSleepSolutions\Contracts\Repositories\InsurancePreauth as Repository;
use DB;

class InsurancePreauth extends Model implements Resource, Repository
{
    use WithoutCreatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_insurance_preauth';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    private $preAuthorizationStatuses = [
        'DSS_PREAUTH_PENDING'         => 0,
        'DSS_PREAUTH_COMPLETE'        => 1,
        'DSS_PREAUTH_PREAUTH_PENDING' => 2,
        'DSS_PREAUTH_REJECTED'        => 3
    ];

    public function scopeCompleted($query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_PREAUTH_COMPLETE']);
    }

    public function scopePending($query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_PREAUTH_PENDING']);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_PREAUTH_REJECTED']);
    }

    public function scopeBasedPreauth($query, $docId = 0)
    {
        return $this->select(DB::raw('COUNT(id) AS total'))
            ->where('doc_id', $docId)
            ->whereRaw('COALESCE(viewed, 0) != 1');
    }

    public function getCompleted($docId = 0)
    {
        return $this->basedPreauth($docId)
            ->completed()
            ->first();
    }

    public function getPending($docId = 0)
    {
        return $this->basedPreauth($docId)
            ->pending()
            ->first();
    }

    public function getRejected($docId = 0)
    {
        return $this->basedPreauth($docId)
            ->rejected()
            ->first();
    }

    public function getListVobs(
        $docId       = 0, 
        // $status      = 'rejected', 
        $viewed      = 1, 
        $sortColumn  = 'status',
        $sortDir     = 'desc',
        $vobsPerPage = 30,
        $pageNumber  = 0
    ) {
        $offset = $vobsPerPage * $pageNumber;

        $query = $this->select(DB::raw('
                preauth.id,
                p.firstname,
                p.lastname,
                preauth.viewed,
                preauth.front_office_request_date,
                preauth.patient_id,
                preauth.status,
                preauth.reject_reason
            '))
            ->from(DB::raw('dental_insurance_preauth preauth'))
            ->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'preauth.patient_id')
            ->where('preauth.doc_id', '=', $docId);

        // if(isset($status)) {
        //     $query = $query->where('preauth.status', '=', $status);
        // }

        if($viewed == 0) {
            $query = $query->where('preauth.viewed', '=', 0)->orWhere('preauth.viewed', '=', 'NULL');
        }

        $results = $query->orderBy($sortColumn, $sortDir)
            ->skip($offset)
            ->take($vobsPerPage)
            ->get();

        $countQuery = $this->select(DB::raw('
                COUNT(preauth.id) AS total
            '))
            ->from(DB::raw('dental_insurance_preauth preauth'))
            ->where('preauth.doc_id', '=', $docId);

        if($viewed == 0) {
            $countQuery = $countQuery->where('preauth.viewed', '=', 0)->orWhere('preauth.viewed', '=', 'NULL');
        }

        $countResult = $countQuery->get();

        return [
            'results' => $results,
            'count' => $countResult
        ];
    }

    public function alterVob(
        $docId         = 1,
        $vobParam      = 'viewed',
        $vobParamValue = 0,
        $vobId         = 0,
        $patientId     = 0
    ) {
        $query = $this
        ->where('id', '=', $vobId)
        ->where('patient_id', '=', $patientId)
            ->update([$vobParam => $vobParamValue]);

        return 'updated';
    }
}

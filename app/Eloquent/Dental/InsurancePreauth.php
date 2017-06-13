<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth as Resource;
use DentalSleepSolutions\Contracts\Repositories\InsurancePreauth as Repository;
use Carbon\Carbon;
use DB;

class InsurancePreauth extends Model implements Resource, Repository
{
    use WithoutCreatedTimestamp;

    // Pre-authorization statuses (pre-auth)
    const DSS_PREAUTH_PENDING = 0;
    const DSS_PREAUTH_COMPLETE = 1;
    const DSS_PREAUTH_PREAUTH_PENDING = 2;
    const DSS_PREAUTH_REJECTED = 3;

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
        'DSS_PREAUTH_REJECTED'        => 3,
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

    public function getPendingVOBByContactId($contactId)
    {
        return $this->select('ip.*')
            ->from(DB::raw('dental_insurance_preauth ip'))
            ->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'ip.patient_id')
            ->where(function($query) use ($contactId) {
                $query->where(function($query) use ($contactId) {
                    $query->where('p.p_m_ins_co', '=', $contactId)
                        ->orWhere('p.s_m_ins_co', '=', $contactId);
                })->where(function($query) {
                    $query->where('ip.status', '=', self::DSS_PREAUTH_PENDING)
                        ->orWhere('ip.status', '=', self::DSS_PREAUTH_PREAUTH_PENDING);
                });
            })->orderBy('ip.front_office_request_date', 'desc')
            ->first();
    }

    public function getListVobs(
        $docId       = 0, 
        $viewed      = null, 
        $sortColumn  = 'status',
        $sortDir     = 'desc',
        $vobsPerPage = 20,
        $pageNumber  = 0
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

        if (isset($viewed)) {
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
            'result' => $query->skip($offset)
                ->take($vobsPerPage)
                ->get()
        ];
    }

    public function updateVob($newPatientId, $name)
    {
        $rejectReason = $name . ' altered patient insurance information requiring VOB resubmission on ' . Carbon::now()->format('m/d/Y h:i');

        return $this->where('patient_id', $newPatientId)
            ->where(function($query) {
                $query->where('status', '=', self::DSS_PREAUTH_PENDING)
                    ->orWhere('status', '=', self::DSS_PREAUTH_PREAUTH_PENDING);
            })
            ->update([
                'status'        => self::DSS_PREAUTH_REJECTED,
                'reject_reason' => $rejectReason,
                'viewed'        => 1
            ]);
    }

    public function getPendingVob($patientId)
    {
        return $this->where('patient_id', $patientId)
            ->where(function($query) {
                $query->where('status', '=', self::DSS_PREAUTH_PENDING)
                    ->orWhere('status', '=', self::DSS_PREAUTH_PREAUTH_PENDING);
            })
            ->orderBy('front_office_request_date', 'desc')
            ->first();
    }
}

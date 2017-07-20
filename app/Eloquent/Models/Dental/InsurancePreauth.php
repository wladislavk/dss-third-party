<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use Carbon\Carbon;
use DB;

/**
 * @SWG\Definition(
 *     definition="InsurancePreauth",
 *     type="object",
 *     required={"id", "doc_id", "patient_id", "ins_rank", "trxn_code_covered", "has_out_of_network_benefits", "is_hmo", "hmo_needs_auth", "out_of_pocket_met", "network_benefits", "deductible_from", "in_out_of_pocket_met"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="doc_id", type="integer"),
 *     @SWG\Property(property="patient_id", type="integer"),
 *     @SWG\Property(property="ins_co", type="string"),
 *     @SWG\Property(property="ins_rank", type="string"),
 *     @SWG\Property(property="ins_phone", type="string"),
 *     @SWG\Property(property="patient_ins_group_id", type="string"),
 *     @SWG\Property(property="patient_ins_id", type="string"),
 *     @SWG\Property(property="patient_firstname", type="string"),
 *     @SWG\Property(property="patient_lastname", type="string"),
 *     @SWG\Property(property="patient_add1", type="string"),
 *     @SWG\Property(property="patient_add2", type="string"),
 *     @SWG\Property(property="patient_city", type="string"),
 *     @SWG\Property(property="patient_state", type="string"),
 *     @SWG\Property(property="patient_zip", type="string"),
 *     @SWG\Property(property="patient_dob", type="string"),
 *     @SWG\Property(property="insured_first_name", type="string"),
 *     @SWG\Property(property="insured_last_name", type="string"),
 *     @SWG\Property(property="insured_dob", type="string"),
 *     @SWG\Property(property="doc_npi", type="string"),
 *     @SWG\Property(property="referring_doc_npi", type="string"),
 *     @SWG\Property(property="trxn_code_amount", type="float"),
 *     @SWG\Property(property="diagnosis_code", type="string"),
 *     @SWG\Property(property="date_of_call", type="string"),
 *     @SWG\Property(property="insurance_rep", type="string"),
 *     @SWG\Property(property="call_reference_num", type="string"),
 *     @SWG\Property(property="doc_medicare_npi", type="string"),
 *     @SWG\Property(property="doc_tax_id_or_ssn", type="string"),
 *     @SWG\Property(property="ins_effective_date", type="string"),
 *     @SWG\Property(property="ins_cal_year_start", type="string"),
 *     @SWG\Property(property="ins_cal_year_end", type="string"),
 *     @SWG\Property(property="trxn_code_covered", type="integer"),
 *     @SWG\Property(property="code_covered_notes", type="string"),
 *     @SWG\Property(property="has_out_of_network_benefits", type="integer"),
 *     @SWG\Property(property="out_of_network_percentage", type="integer"),
 *     @SWG\Property(property="is_hmo", type="integer"),
 *     @SWG\Property(property="hmo_date_called", type="string"),
 *     @SWG\Property(property="hmo_date_received", type="string"),
 *     @SWG\Property(property="hmo_needs_auth", type="integer"),
 *     @SWG\Property(property="hmo_auth_date_requested", type="string"),
 *     @SWG\Property(property="hmo_auth_date_received", type="string"),
 *     @SWG\Property(property="hmo_auth_notes", type="string"),
 *     @SWG\Property(property="in_network_percentage", type="integer"),
 *     @SWG\Property(property="in_network_appeal_date_sent", type="string"),
 *     @SWG\Property(property="in_network_appeal_date_received", type="string"),
 *     @SWG\Property(property="is_pre_auth_required", type="integer"),
 *     @SWG\Property(property="verbal_pre_auth_name", type="string"),
 *     @SWG\Property(property="verbal_pre_auth_ref_num", type="string"),
 *     @SWG\Property(property="verbal_pre_auth_notes", type="string"),
 *     @SWG\Property(property="written_pre_auth_notes", type="string"),
 *     @SWG\Property(property="written_pre_auth_date_received", type="string"),
 *     @SWG\Property(property="front_office_request_date", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="patient_deductible", type="float"),
 *     @SWG\Property(property="patient_amount_met", type="float"),
 *     @SWG\Property(property="family_deductible", type="float"),
 *     @SWG\Property(property="family_amount_met", type="float"),
 *     @SWG\Property(property="deductible_reset_date", type="string"),
 *     @SWG\Property(property="out_of_pocket_met", type="integer"),
 *     @SWG\Property(property="patient_amount_left_to_meet", type="float"),
 *     @SWG\Property(property="expected_insurance_payment", type="float"),
 *     @SWG\Property(property="expected_patient_payment", type="float"),
 *     @SWG\Property(property="network_benefits", type="integer"),
 *     @SWG\Property(property="viewed", type="integer"),
 *     @SWG\Property(property="date_completed", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="how_often", type="string"),
 *     @SWG\Property(property="patient_phone", type="string"),
 *     @SWG\Property(property="pre_auth_num", type="string"),
 *     @SWG\Property(property="family_amount_left_to_meet", type="float"),
 *     @SWG\Property(property="deductible_from", type="integer"),
 *     @SWG\Property(property="reject_reason", type="string"),
 *     @SWG\Property(property="invoice_date", type="string"),
 *     @SWG\Property(property="invoice_amount", type="float"),
 *     @SWG\Property(property="invoice_status", type="integer"),
 *     @SWG\Property(property="invoice_id", type="integer"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime"),
 *     @SWG\Property(property="updated_by", type="integer"),
 *     @SWG\Property(property="doc_name", type="string"),
 *     @SWG\Property(property="doc_practice", type="string"),
 *     @SWG\Property(property="doc_address", type="string"),
 *     @SWG\Property(property="doc_phone", type="string"),
 *     @SWG\Property(property="in_deductible_from", type="integer"),
 *     @SWG\Property(property="in_patient_deductible", type="float"),
 *     @SWG\Property(property="in_patient_amount_met", type="float"),
 *     @SWG\Property(property="in_patient_amount_left_to_meet", type="float"),
 *     @SWG\Property(property="in_family_deductible", type="float"),
 *     @SWG\Property(property="in_family_amount_met", type="float"),
 *     @SWG\Property(property="in_family_amount_left_to_meet", type="float"),
 *     @SWG\Property(property="in_deductible_reset_date", type="string"),
 *     @SWG\Property(property="in_out_of_pocket_met", type="integer"),
 *     @SWG\Property(property="in_expected_insurance_payment", type="float"),
 *     @SWG\Property(property="in_expected_patient_payment", type="float"),
 *     @SWG\Property(property="in_call_reference_num", type="string"),
 *     @SWG\Property(property="has_in_network_benefits", type="integer"),
 *     @SWG\Property(property="in_is_pre_auth_required", type="integer"),
 *     @SWG\Property(property="in_verbal_pre_auth_name", type="string"),
 *     @SWG\Property(property="in_verbal_pre_auth_ref_num", type="string"),
 *     @SWG\Property(property="in_verbal_pre_auth_notes", type="string"),
 *     @SWG\Property(property="in_written_pre_auth_date_received", type="string"),
 *     @SWG\Property(property="in_pre_auth_num", type="string"),
 *     @SWG\Property(property="in_written_pre_auth_notes", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\InsurancePreauth
 *
 * @property int $id
 * @property int $doc_id
 * @property int $patient_id
 * @property string|null $ins_co
 * @property string $ins_rank
 * @property string|null $ins_phone
 * @property string|null $patient_ins_group_id
 * @property string|null $patient_ins_id
 * @property string|null $patient_firstname
 * @property string|null $patient_lastname
 * @property string|null $patient_add1
 * @property string|null $patient_add2
 * @property string|null $patient_city
 * @property string|null $patient_state
 * @property string|null $patient_zip
 * @property string|null $patient_dob
 * @property string|null $insured_first_name
 * @property string|null $insured_last_name
 * @property string|null $insured_dob
 * @property string|null $doc_npi
 * @property string|null $referring_doc_npi
 * @property float|null $trxn_code_amount
 * @property string|null $diagnosis_code
 * @property string|null $date_of_call
 * @property string|null $insurance_rep
 * @property string|null $call_reference_num
 * @property string|null $doc_medicare_npi
 * @property string|null $doc_tax_id_or_ssn
 * @property string|null $ins_effective_date
 * @property string|null $ins_cal_year_start
 * @property string|null $ins_cal_year_end
 * @property int $trxn_code_covered
 * @property string|null $code_covered_notes
 * @property int $has_out_of_network_benefits
 * @property int|null $out_of_network_percentage
 * @property int $is_hmo
 * @property string|null $hmo_date_called
 * @property string|null $hmo_date_received
 * @property int $hmo_needs_auth
 * @property string|null $hmo_auth_date_requested
 * @property string|null $hmo_auth_date_received
 * @property string|null $hmo_auth_notes
 * @property int|null $in_network_percentage
 * @property string|null $in_network_appeal_date_sent
 * @property string|null $in_network_appeal_date_received
 * @property int|null $is_pre_auth_required
 * @property string|null $verbal_pre_auth_name
 * @property string|null $verbal_pre_auth_ref_num
 * @property string|null $verbal_pre_auth_notes
 * @property string|null $written_pre_auth_notes
 * @property string|null $written_pre_auth_date_received
 * @property string|null $front_office_request_date
 * @property int|null $status
 * @property float|null $patient_deductible
 * @property float|null $patient_amount_met
 * @property float|null $family_deductible
 * @property float|null $family_amount_met
 * @property string|null $deductible_reset_date
 * @property int $out_of_pocket_met
 * @property float|null $patient_amount_left_to_meet
 * @property float|null $expected_insurance_payment
 * @property float|null $expected_patient_payment
 * @property int $network_benefits
 * @property int|null $viewed
 * @property string|null $date_completed
 * @property int|null $userid
 * @property string|null $how_often
 * @property string|null $patient_phone
 * @property string|null $pre_auth_num
 * @property float|null $family_amount_left_to_meet
 * @property int $deductible_from
 * @property string|null $reject_reason
 * @property string|null $invoice_date
 * @property float|null $invoice_amount
 * @property int|null $invoice_status
 * @property int|null $invoice_id
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property string|null $doc_name
 * @property string|null $doc_practice
 * @property string|null $doc_address
 * @property string|null $doc_phone
 * @property int|null $in_deductible_from
 * @property float|null $in_patient_deductible
 * @property float|null $in_patient_amount_met
 * @property float|null $in_patient_amount_left_to_meet
 * @property float|null $in_family_deductible
 * @property float|null $in_family_amount_met
 * @property float|null $in_family_amount_left_to_meet
 * @property string|null $in_deductible_reset_date
 * @property int $in_out_of_pocket_met
 * @property float|null $in_expected_insurance_payment
 * @property float|null $in_expected_patient_payment
 * @property string|null $in_call_reference_num
 * @property int|null $has_in_network_benefits
 * @property int|null $in_is_pre_auth_required
 * @property string|null $in_verbal_pre_auth_name
 * @property string|null $in_verbal_pre_auth_ref_num
 * @property string|null $in_verbal_pre_auth_notes
 * @property string|null $in_written_pre_auth_date_received
 * @property string|null $in_pre_auth_num
 * @property string|null $in_written_pre_auth_notes
 * @mixin \Eloquent
 */
class InsurancePreauth extends AbstractModel implements Resource
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

    public function getPlural()
    {
        return 'InsurancePreauth';
    }
}

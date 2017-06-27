<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth as Resource;
use DentalSleepSolutions\Contracts\Repositories\InsurancePreauth as Repository;
use Carbon\Carbon;
use DB;

/**
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth basedPreauth($docId = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth completed()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth pending()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth rejected()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereCallReferenceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereCodeCoveredNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDateCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDateOfCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDeductibleFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDeductibleResetDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDiagnosisCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocMedicareNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocPractice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocTaxIdOrSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereExpectedInsurancePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereExpectedPatientPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFamilyAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFamilyAmountMet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFamilyDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFrontOfficeRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHasInNetworkBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHasOutOfNetworkBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoAuthDateReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoAuthDateRequested($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoAuthNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoDateCalled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoDateReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoNeedsAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHowOften($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInCallReferenceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInDeductibleFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInDeductibleResetDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInExpectedInsurancePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInExpectedPatientPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInFamilyAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInFamilyAmountMet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInFamilyDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInIsPreAuthRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInNetworkAppealDateReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInNetworkAppealDateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInNetworkPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInOutOfPocketMet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPatientAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPatientAmountMet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPatientDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPreAuthNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInVerbalPreAuthName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInVerbalPreAuthNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInVerbalPreAuthRefNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInWrittenPreAuthDateReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInWrittenPreAuthNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsCalYearEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsCalYearStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuranceRep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuredDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuredFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuredLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereIsHmo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereIsPreAuthRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereNetworkBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereOutOfNetworkPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereOutOfPocketMet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAdd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAdd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAmountMet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientInsGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientInsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePreAuthNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereReferringDocNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereTrxnCodeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereTrxnCodeCovered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereVerbalPreAuthName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereVerbalPreAuthNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereVerbalPreAuthRefNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereWrittenPreAuthDateReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereWrittenPreAuthNotes($value)
 * @mixin \Eloquent
 */
class InsurancePreauth extends AbstractModel implements Resource, Repository
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

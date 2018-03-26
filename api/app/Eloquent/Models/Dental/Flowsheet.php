<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Flowsheet",
 *     type="object",
 *     required={"flowsheetid", "step"},
 *     @SWG\Property(property="flowsheetid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="inquiry_call_apt", type="string"),
 *     @SWG\Property(property="inquiry_call_comp", type="string"),
 *     @SWG\Property(property="send_np", type="string"),
 *     @SWG\Property(property="send_np_comp", type="string"),
 *     @SWG\Property(property="acquire_ss_apt", type="string"),
 *     @SWG\Property(property="acquire_ss_comp", type="string"),
 *     @SWG\Property(property="referral_dss_apt", type="string"),
 *     @SWG\Property(property="referral_dss_comp", type="string"),
 *     @SWG\Property(property="ss_requested_apt", type="string"),
 *     @SWG\Property(property="ss_requested_comp", type="string"),
 *     @SWG\Property(property="ss_received_apt", type="string"),
 *     @SWG\Property(property="ss_received_comp", type="string"),
 *     @SWG\Property(property="consultation_apt", type="string"),
 *     @SWG\Property(property="consultation_comp", type="string"),
 *     @SWG\Property(property="m_insurance_apt", type="string"),
 *     @SWG\Property(property="m_insurance_comp", type="string"),
 *     @SWG\Property(property="select_type", type="string"),
 *     @SWG\Property(property="exam_impressions_apt", type="string"),
 *     @SWG\Property(property="exam_impressions_comp", type="string"),
 *     @SWG\Property(property="ltr_physicians_apt", type="string"),
 *     @SWG\Property(property="ltr_physicians_comp", type="string"),
 *     @SWG\Property(property="ltr_marketing_apt", type="string"),
 *     @SWG\Property(property="ltr_marketing_comp", type="string"),
 *     @SWG\Property(property="delivery_device_apt", type="string"),
 *     @SWG\Property(property="delivery_device_comp", type="string"),
 *     @SWG\Property(property="ltr_marketing_pt_apt", type="string"),
 *     @SWG\Property(property="ltr_marketing_pt_comp", type="string"),
 *     @SWG\Property(property="ltr_corr_phy_apt", type="string"),
 *     @SWG\Property(property="ltr_corr_phy_comp", type="string"),
 *     @SWG\Property(property="first_check_apt", type="string"),
 *     @SWG\Property(property="first_check_comp", type="string"),
 *     @SWG\Property(property="add_check_apt", type="string"),
 *     @SWG\Property(property="add_check_comp", type="string"),
 *     @SWG\Property(property="home_sleep_apt", type="string"),
 *     @SWG\Property(property="home_sleep_comp", type="string"),
 *     @SWG\Property(property="further_checks_apt", type="string"),
 *     @SWG\Property(property="further_checks_comp", type="string"),
 *     @SWG\Property(property="comp_treatment_apt", type="string"),
 *     @SWG\Property(property="comp_treatment_comp", type="string"),
 *     @SWG\Property(property="ltr_copy_ss_apt", type="string"),
 *     @SWG\Property(property="ltr_copy_ss_comp", type="string"),
 *     @SWG\Property(property="annual_exam_apt", type="string"),
 *     @SWG\Property(property="annual_exam_comp", type="string"),
 *     @SWG\Property(property="pos_home_sleep_apt", type="string"),
 *     @SWG\Property(property="pos_home_sleep_comp", type="string"),
 *     @SWG\Property(property="ltr_corr_phy1_apt", type="string"),
 *     @SWG\Property(property="ltr_corr_phy1_comp", type="string"),
 *     @SWG\Property(property="ambulatory_ss_apt", type="string"),
 *     @SWG\Property(property="ambulatory_ss_comp", type="string"),
 *     @SWG\Property(property="diag_s_md_apt", type="string"),
 *     @SWG\Property(property="diag_s_md_comp", type="string"),
 *     @SWG\Property(property="psg_apt", type="string"),
 *     @SWG\Property(property="psg_comp", type="string"),
 *     @SWG\Property(property="pt_not_ds_apt", type="string"),
 *     @SWG\Property(property="pt_not_ds_comp", type="string"),
 *     @SWG\Property(property="not_candidate_apt", type="string"),
 *     @SWG\Property(property="not_candidate_comp", type="string"),
 *     @SWG\Property(property="fin_restraints_apt", type="string"),
 *     @SWG\Property(property="fin_restraints_comp", type="string"),
 *     @SWG\Property(property="pt_needing_apt", type="string"),
 *     @SWG\Property(property="pt_needing_comp", type="string"),
 *     @SWG\Property(property="inadequate_apt", type="string"),
 *     @SWG\Property(property="inadequate_comp", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="step", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet
 *
 * @property int $flowsheetid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $inquiry_call_apt
 * @property string|null $inquiry_call_comp
 * @property string|null $send_np
 * @property string|null $send_np_comp
 * @property string|null $acquire_ss_apt
 * @property string|null $acquire_ss_comp
 * @property string|null $referral_dss_apt
 * @property string|null $referral_dss_comp
 * @property string|null $ss_requested_apt
 * @property string|null $ss_requested_comp
 * @property string|null $ss_received_apt
 * @property string|null $ss_received_comp
 * @property string|null $consultation_apt
 * @property string|null $consultation_comp
 * @property string|null $m_insurance_apt
 * @property string|null $m_insurance_comp
 * @property string|null $select_type
 * @property string|null $exam_impressions_apt
 * @property string|null $exam_impressions_comp
 * @property string|null $ltr_physicians_apt
 * @property string|null $ltr_physicians_comp
 * @property string|null $ltr_marketing_apt
 * @property string|null $ltr_marketing_comp
 * @property string|null $delivery_device_apt
 * @property string|null $delivery_device_comp
 * @property string|null $ltr_marketing_pt_apt
 * @property string|null $ltr_marketing_pt_comp
 * @property string|null $ltr_corr_phy_apt
 * @property string|null $ltr_corr_phy_comp
 * @property string|null $first_check_apt
 * @property string|null $first_check_comp
 * @property string|null $add_check_apt
 * @property string|null $add_check_comp
 * @property string|null $home_sleep_apt
 * @property string|null $home_sleep_comp
 * @property string|null $further_checks_apt
 * @property string|null $further_checks_comp
 * @property string|null $comp_treatment_apt
 * @property string|null $comp_treatment_comp
 * @property string|null $ltr_copy_ss_apt
 * @property string|null $ltr_copy_ss_comp
 * @property string|null $annual_exam_apt
 * @property string|null $annual_exam_comp
 * @property string|null $pos_home_sleep_apt
 * @property string|null $pos_home_sleep_comp
 * @property string|null $ltr_corr_phy1_apt
 * @property string|null $ltr_corr_phy1_comp
 * @property string|null $ambulatory_ss_apt
 * @property string|null $ambulatory_ss_comp
 * @property string|null $diag_s_md_apt
 * @property string|null $diag_s_md_comp
 * @property string|null $psg_apt
 * @property string|null $psg_comp
 * @property string|null $pt_not_ds_apt
 * @property string|null $pt_not_ds_comp
 * @property string|null $not_candidate_apt
 * @property string|null $not_candidate_comp
 * @property string|null $fin_restraints_apt
 * @property string|null $fin_restraints_comp
 * @property string|null $pt_needing_apt
 * @property string|null $pt_needing_comp
 * @property string|null $inadequate_apt
 * @property string|null $inadequate_comp
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property int $step
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAcquireSsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAcquireSsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAddCheckApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAddCheckComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAmbulatorySsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAmbulatorySsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAnnualExamApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereAnnualExamComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereCompTreatmentApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereCompTreatmentComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereConsultationApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereConsultationComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereDeliveryDeviceApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereDeliveryDeviceComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereDiagSMdApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereDiagSMdComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereExamImpressionsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereExamImpressionsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFinRestraintsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFinRestraintsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFirstCheckApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFirstCheckComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFlowsheetid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFurtherChecksApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereFurtherChecksComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereHomeSleepApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereHomeSleepComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereInadequateApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereInadequateComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereInquiryCallApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereInquiryCallComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrCopySsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrCopySsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrCorrPhy1Apt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrCorrPhy1Comp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrCorrPhyApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrCorrPhyComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrMarketingApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrMarketingComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrMarketingPtApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrMarketingPtComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrPhysiciansApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereLtrPhysiciansComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereMInsuranceApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereMInsuranceComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereNotCandidateApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereNotCandidateComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePosHomeSleepApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePosHomeSleepComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePsgApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePsgComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePtNeedingApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePtNeedingComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePtNotDsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet wherePtNotDsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereReferralDssApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereReferralDssComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereSelectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereSendNp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereSendNpComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereSsReceivedApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereSsReceivedComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereSsRequestedApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereSsRequestedComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet whereUserid($value)
 */
class Flowsheet extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['flowsheetid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_flowsheet';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'flowsheetid';

    const CREATED_AT = 'adddate';
}

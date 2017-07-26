<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="NewFlowsheet",
 *     type="object",
 *     required={"flowsheetid", "lomn", "rxfrommd", "step", "sstep"},
 *     @SWG\Property(property="flowsheetid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="inquiry_call_comp", type="string"),
 *     @SWG\Property(property="send_np", type="string"),
 *     @SWG\Property(property="send_np_comp", type="string"),
 *     @SWG\Property(property="acquire_ss_apt", type="string"),
 *     @SWG\Property(property="acquire_ss_comp", type="string"),
 *     @SWG\Property(property="pt_not_ss", type="string"),
 *     @SWG\Property(property="ss_date_requested", type="string"),
 *     @SWG\Property(property="ss_date_received", type="string"),
 *     @SWG\Property(property="date_referred", type="string"),
 *     @SWG\Property(property="dss_dentists", type="string"),
 *     @SWG\Property(property="ss_requested_apt", type="string"),
 *     @SWG\Property(property="ss_requested_comp", type="string"),
 *     @SWG\Property(property="ss_received_apt", type="string"),
 *     @SWG\Property(property="ss_received_comp", type="string"),
 *     @SWG\Property(property="consultation_apt", type="string"),
 *     @SWG\Property(property="consultation_comp", type="string"),
 *     @SWG\Property(property="m_insurance_date", type="string"),
 *     @SWG\Property(property="select_type", type="string"),
 *     @SWG\Property(property="exam_impressions_apt", type="string"),
 *     @SWG\Property(property="exam_impressions_comp", type="string"),
 *     @SWG\Property(property="dsr_prepared", type="string"),
 *     @SWG\Property(property="dsr_sent", type="string"),
 *     @SWG\Property(property="delivery_device_apt", type="string"),
 *     @SWG\Property(property="delivery_device_comp", type="string"),
 *     @SWG\Property(property="dsr_date_delivered", type="string"),
 *     @SWG\Property(property="ltr_phy_prepared", type="string"),
 *     @SWG\Property(property="ltr_phy_sent", type="string"),
 *     @SWG\Property(property="first_check_apt", type="string"),
 *     @SWG\Property(property="first_check_comp", type="string"),
 *     @SWG\Property(property="add_check_apt", type="string"),
 *     @SWG\Property(property="add_check_comp", type="string"),
 *     @SWG\Property(property="home_sleep_apt", type="string"),
 *     @SWG\Property(property="home_sleep_comp", type="string"),
 *     @SWG\Property(property="further_checks_apt", type="string"),
 *     @SWG\Property(property="further_checks_comp", type="string"),
 *     @SWG\Property(property="comp_treatment_date", type="string"),
 *     @SWG\Property(property="portable_date_comp", type="string"),
 *     @SWG\Property(property="treatment_success", type="string"),
 *     @SWG\Property(property="ltr_doc_ss_date_prepared", type="string"),
 *     @SWG\Property(property="ltr_doc_ss_date_sent", type="string"),
 *     @SWG\Property(property="annual_exam_apt", type="string"),
 *     @SWG\Property(property="annual_exam_comp", type="string"),
 *     @SWG\Property(property="ltr_doc_pt_date_prepared", type="string"),
 *     @SWG\Property(property="ltr_doc_pt_date_sent", type="string"),
 *     @SWG\Property(property="ambulatory_ss_apt", type="string"),
 *     @SWG\Property(property="ambulatory_ss_comp", type="string"),
 *     @SWG\Property(property="diag_s_md_sent", type="string"),
 *     @SWG\Property(property="diag_s_md_received", type="string"),
 *     @SWG\Property(property="psg_apt", type="string"),
 *     @SWG\Property(property="psg_comp", type="string"),
 *     @SWG\Property(property="sleep_lab", type="string"),
 *     @SWG\Property(property="lomn", type="string"),
 *     @SWG\Property(property="rxfrommd", type="string"),
 *     @SWG\Property(property="not_candidate", type="string"),
 *     @SWG\Property(property="financial_restraints", type="string"),
 *     @SWG\Property(property="pt_needing_dental_work", type="string"),
 *     @SWG\Property(property="inadequate_dentition", type="string"),
 *     @SWG\Property(property="pt_not_ds_other", type="string"),
 *     @SWG\Property(property="ltr_pp_date_prepared", type="string"),
 *     @SWG\Property(property="ltr_pp_date_sent", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="step", type="integer"),
 *     @SWG\Property(property="sstep", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet
 *
 * @property int $flowsheetid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $inquiry_call_comp
 * @property string|null $send_np
 * @property string|null $send_np_comp
 * @property string|null $acquire_ss_apt
 * @property string|null $acquire_ss_comp
 * @property string|null $pt_not_ss
 * @property string|null $ss_date_requested
 * @property string|null $ss_date_received
 * @property string|null $date_referred
 * @property string|null $dss_dentists
 * @property string|null $ss_requested_apt
 * @property string|null $ss_requested_comp
 * @property string|null $ss_received_apt
 * @property string|null $ss_received_comp
 * @property string|null $consultation_apt
 * @property string|null $consultation_comp
 * @property string|null $m_insurance_date
 * @property string|null $select_type
 * @property string|null $exam_impressions_apt
 * @property string|null $exam_impressions_comp
 * @property string|null $dsr_prepared
 * @property string|null $dsr_sent
 * @property string|null $delivery_device_apt
 * @property string|null $delivery_device_comp
 * @property string|null $dsr_date_delivered
 * @property string|null $ltr_phy_prepared
 * @property string|null $ltr_phy_sent
 * @property string|null $first_check_apt
 * @property string|null $first_check_comp
 * @property string|null $add_check_apt
 * @property string|null $add_check_comp
 * @property string|null $home_sleep_apt
 * @property string|null $home_sleep_comp
 * @property string|null $further_checks_apt
 * @property string|null $further_checks_comp
 * @property string|null $comp_treatment_date
 * @property string|null $portable_date_comp
 * @property string|null $treatment_success
 * @property string|null $ltr_doc_ss_date_prepared
 * @property string|null $ltr_doc_ss_date_sent
 * @property string|null $annual_exam_apt
 * @property string|null $annual_exam_comp
 * @property string|null $ltr_doc_pt_date_prepared
 * @property string|null $ltr_doc_pt_date_sent
 * @property string|null $ambulatory_ss_apt
 * @property string|null $ambulatory_ss_comp
 * @property string|null $diag_s_md_sent
 * @property string|null $diag_s_md_received
 * @property string|null $psg_apt
 * @property string|null $psg_comp
 * @property string|null $sleep_lab
 * @property string $lomn
 * @property string $rxfrommd
 * @property string|null $not_candidate
 * @property string|null $financial_restraints
 * @property string|null $pt_needing_dental_work
 * @property string|null $inadequate_dentition
 * @property string|null $pt_not_ds_other
 * @property string|null $ltr_pp_date_prepared
 * @property string|null $ltr_pp_date_sent
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int $step
 * @property int $sstep
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAcquireSsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAcquireSsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAddCheckApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAddCheckComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAmbulatorySsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAmbulatorySsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAnnualExamApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereAnnualExamComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereCompTreatmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereConsultationApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereConsultationComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDateReferred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDeliveryDeviceApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDeliveryDeviceComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDiagSMdReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDiagSMdSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDsrDateDelivered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDsrPrepared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDsrSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereDssDentists($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereExamImpressionsApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereExamImpressionsComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereFinancialRestraints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereFirstCheckApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereFirstCheckComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereFlowsheetid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereFurtherChecksApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereFurtherChecksComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereHomeSleepApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereHomeSleepComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereInadequateDentition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereInquiryCallComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLomn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrDocPtDatePrepared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrDocPtDateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrDocSsDatePrepared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrDocSsDateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrPhyPrepared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrPhySent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrPpDatePrepared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereLtrPpDateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereMInsuranceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereNotCandidate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet wherePortableDateComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet wherePsgApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet wherePsgComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet wherePtNeedingDentalWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet wherePtNotDsOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet wherePtNotSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereRxfrommd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSelectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSendNp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSendNpComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSleepLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSsDateReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSsDateRequested($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSsReceivedApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSsReceivedComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSsRequestedApt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSsRequestedComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereSstep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereTreatmentSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet whereUserid($value)
 */
class NewFlowsheet extends AbstractModel
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
    protected $table = 'dental_flowsheet_new';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'flowsheetid';

    const CREATED_AT = 'adddate';
}

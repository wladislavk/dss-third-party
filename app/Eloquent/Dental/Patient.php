<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Patient as Resource;
use DentalSleepSolutions\Contracts\Repositories\Patients as Repository;
use DB;

/**
 * DentalSleepSolutions\Eloquent\Dental\Patient
 *
 * @property int $patientid
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $salutation
 * @property string $member_no
 * @property string $group_no
 * @property string $plan_no
 * @property string|null $dob
 * @property string|null $add1
 * @property string|null $add2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $gender
 * @property string|null $marital_status
 * @property string|null $ssn
 * @property string|null $internal_patient
 * @property string|null $home_phone
 * @property string|null $work_phone
 * @property string|null $cell_phone
 * @property string|null $email
 * @property string|null $patient_notes
 * @property string|null $alert_text
 * @property int|null $display_alert
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $p_d_party
 * @property string|null $p_d_relation
 * @property string|null $p_d_other
 * @property string|null $p_d_employer
 * @property string|null $p_d_ins_co
 * @property string|null $p_d_ins_id
 * @property string|null $s_d_party
 * @property string|null $s_d_relation
 * @property string|null $s_d_other
 * @property string|null $s_d_employer
 * @property string|null $s_d_ins_co
 * @property string|null $s_d_ins_id
 * @property string|null $p_m_partyfname
 * @property string $p_m_partymname
 * @property string $p_m_partylname
 * @property string|null $p_m_relation
 * @property string|null $p_m_other
 * @property string|null $p_m_employer
 * @property string|null $p_m_ins_co
 * @property string|null $p_m_ins_id
 * @property string|null $s_m_partyfname
 * @property string $s_m_partymname
 * @property string $s_m_partylname
 * @property string|null $s_m_relation
 * @property string|null $s_m_other
 * @property string|null $s_m_employer
 * @property string|null $s_m_ins_co
 * @property string|null $s_m_ins_id
 * @property string $p_m_ins_grp
 * @property string $s_m_ins_grp
 * @property string $p_m_ins_plan
 * @property string $s_m_ins_plan
 * @property string $p_m_dss_file
 * @property string $s_m_dss_file
 * @property string $p_m_ins_type
 * @property string $s_m_ins_type
 * @property string $p_m_ins_ass
 * @property string $s_m_ins_ass
 * @property string $ins_dob
 * @property string $ins2_dob
 * @property string|null $employer
 * @property string|null $emp_add1
 * @property string|null $emp_add2
 * @property string|null $emp_city
 * @property string|null $emp_state
 * @property string|null $emp_zip
 * @property string|null $emp_phone
 * @property string|null $emp_fax
 * @property string|null $plan_name
 * @property string|null $group_number
 * @property string|null $ins_type
 * @property string|null $accept_assignment
 * @property string|null $print_signature
 * @property string|null $medical_insurance
 * @property string|null $mark_yes
 * @property string|null $inactive
 * @property string|null $partner_name
 * @property string|null $emergency_name
 * @property string|null $emergency_number
 * @property string|null $referred_source
 * @property string|null $referred_by
 * @property int $premedcheck
 * @property string $premed
 * @property string $docsleep
 * @property string $docpcp
 * @property string $docdentist
 * @property string $docent
 * @property string $docmdother
 * @property string|null $preferredcontact
 * @property string|null $copyreqdate
 * @property string|null $best_time
 * @property string|null $best_number
 * @property string|null $emergency_relationship
 * @property string|null $has_s_m_ins
 * @property string|null $referred_notes
 * @property string|null $login
 * @property string|null $password
 * @property string|null $salt
 * @property string|null $recover_hash
 * @property \Carbon\Carbon|null $recover_time
 * @property int|null $registered
 * @property string|null $access_code
 * @property int|null $parent_patientid
 * @property string|null $has_p_m_ins
 * @property int|null $registration_status
 * @property \Carbon\Carbon|null $text_date
 * @property int $text_num
 * @property int $use_patient_portal
 * @property \Carbon\Carbon|null $registration_senton
 * @property string|null $preferred_name
 * @property string|null $feet
 * @property string|null $inches
 * @property string|null $weight
 * @property string|null $bmi
 * @property int|null $symptoms_status
 * @property int|null $sleep_status
 * @property int|null $treatments_status
 * @property int|null $history_status
 * @property \Carbon\Carbon|null $access_code_date
 * @property int $email_bounce
 * @property string $docmdother2
 * @property string $docmdother3
 * @property int $last_reg_sect
 * @property int|null $access_type
 * @property string|null $p_m_eligible_id
 * @property string|null $p_m_eligible_payer_id
 * @property string|null $p_m_eligible_payer_name
 * @property string|null $p_m_gender
 * @property string|null $s_m_gender
 * @property int|null $p_m_same_address
 * @property string|null $p_m_address
 * @property string|null $p_m_state
 * @property string|null $p_m_city
 * @property string|null $p_m_zip
 * @property int|null $s_m_same_address
 * @property string|null $s_m_address
 * @property string|null $s_m_city
 * @property string|null $s_m_state
 * @property string|null $s_m_zip
 * @property \Carbon\Carbon|null $new_fee_date
 * @property float|null $new_fee_amount
 * @property string|null $new_fee_desc
 * @property int|null $new_fee_invoice_id
 * @property string|null $s_m_eligible_payer_id
 * @property string|null $s_m_eligible_payer_name
 * @property-read \DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation $airwayEvaluation
 * @property-read \DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam $dentalClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam $tmjClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam $tongueClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam $tonsilsClinicalExam
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient active()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient all()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAcceptAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAccessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAccessCodeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAccessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAdd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAdd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAlertText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereBestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereBestTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereCellPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereCopyreqdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDisplayAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocdentist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocmdother($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocmdother2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocmdother3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocpcp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocsleep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmailBounce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmergencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmergencyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmergencyRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpAdd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpAdd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereFeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereGroupNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereGroupNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHasPMIns($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHasSMIns($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHistoryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHomePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInactive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereIns2Dob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInsDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInternalPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereLastRegSect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMarkYes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMedicalInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMemberNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDInsCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDInsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDParty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMDssFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEligibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEligiblePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEligiblePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsAss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsGrp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMPartyfname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMPartylname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMPartymname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMSameAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereParentPatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePatientNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePlanName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePlanNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePreferredName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePreferredcontact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePremed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePremedcheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePrintSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRecoverHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRecoverTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereReferredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereReferredNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereReferredSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRegistrationSenton($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRegistrationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDInsCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDInsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDParty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMDssFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMEligiblePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMEligiblePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsAss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsGrp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMPartyfname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMPartylname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMPartymname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMSameAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSalt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSleepStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSymptomsStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereTextDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereTextNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereTreatmentsStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereUsePatientPortal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereWorkPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereZip($value)
 * @mixin \Eloquent
 */
class Patient extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    const DSS_REFERRED_PATIENT = 1;
    const DSS_REFERRED_PHYSICIAN = 2;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['patientid', 'password', 'salt'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'patientid';


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'recover_time', 'text_date', 'registration_senton',
        'access_code_date', 'new_fee_date'
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * RELATIONS
     */
    public function tongueClinicalExam()
    {
        return $this->hasOne(TongueClinicalExam::class, 'patientid', 'patientid');
    }

    public function tonsilsClinicalExam()
    {
        return $this->hasOne(TonsilsClinicalExam::class, 'patientid', 'patientid');
    }

    public function airwayEvaluation()
    {
        return $this->hasOne(AirwayEvaluation::class, 'patientid', 'patientid');
    }

    public function dentalClinicalExam()
    {
        return $this->hasOne(DentalClinicalExam::class, 'patientid', 'patientid');
    }

    public function tmjClinicalExam()
    {
        return $this->hasOne(TmjClinicalExam::class, 'patientid', 'patientid');
    }

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection|Patient[]
     */
    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    public function getNumber($docId = 0)
    {
        return $this->select(DB::raw('COUNT(p2.patientid) AS total'))
            ->from(DB::raw('dental_patients p2'))
            ->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'p2.parent_patientid')
            ->where('p.docid', $docId)
            ->first();
    }

    public function getDuplicates($docId = 0)
    {
        return $this->select(DB::raw('COUNT(p.patientid) AS total'))
            ->from(DB::raw('dental_patients p'))
            ->whereIn('p.status', [3, 4])
            ->where('p.docid', $docId)
            ->whereRaw("
                (SELECT COUNT(dp.patientid)
                FROM dental_patients dp
                WHERE dp.status = 1
                    AND dp.docid = ?
                    AND (
                        (
                            dp.firstname = p.firstname
                            AND dp.lastname = p.lastname
                        )
                        OR (
                            dp.add1 = p.add1
                            AND dp.city = p.city
                            AND dp.state = p.state
                            AND dp.zip = p.zip
                        )
                    )
                ) != 0", [$docId]
            )
            ->first();
    }

    public function getBounces($docId = 0)
    {
        return $this->select(DB::raw('COUNT(p.patientid) AS total'))
            ->from(DB::raw('dental_patients p'))
            ->where('p.email_bounce', 1)
            ->where('p.docid', $docId)
            ->first();
    }

    public function getListPatients($docId = 0, $names)
    {
        if (empty($names[0])) {
            $names[0] = '';
        }

        if (empty($names[1])) {
            $names[1] = '';
        }

        if (empty($names[2])) {
            $names[2] = '';
        }

        return $this->select(DB::raw('p.patientid, p.lastname, p.firstname, p.middlename, s.patient_info'))
            ->from(DB::raw('dental_patients p'))
            ->leftJoin(DB::raw('dental_patient_summary s'), 'p.patientid', '=', 's.pid')
            ->where(function($query) use ($names) {
                $query->where(function($query) use ($names) {
                    $query->whereRaw("(lastname LIKE ? OR firstname LIKE ?)", array($names[0] . '%', $names[0] . '%'))
                        ->whereRaw("(lastname LIKE ? OR firstname LIKE ?)", array($names[1] . '%', $names[1] . '%'));
                })
                ->orWhereRaw("(firstname LIKE ? AND middlename LIKE ? AND lastname LIKE ?)", array($names[0] . '%', $names[1] . '%', $names[2] . '%'));
            })
            ->where('p.status', '=', 1)
            ->where('docid', '=', $docId)
            ->orderBy('lastname')
            ->take(12)
            ->get();
    }

    public function deleteForDoctor($patientId = 0, $docId = 0)
    {
        return $this->where('patientid', $patientId)
            ->where('docid', $docId)
            ->delete();
    }

    public function scopeActive($query)
    {
        return $query->where('p.status', 1);
    }

    public function scopeAll($query)
    {
        return $query->where(function($query) {
            $query->where('p.status', 1)
                ->orWhere('p.status', 2);
        });
    }

    public function scopeInactive($query)
    {
        return $query->where('p.status', 2);
    }

    public function findBy(
            $docId           = 0,
            $userType        = 0,
            $patientId       = 0,
            $type            = 1,
            $pageNumber      = 0,
            $patientsPerPage = 30,
            $letter          = '',
            $sortColumn      = '',
            $sortDir         = ''
    ) {
        $sections = $this->getQuerySections(null, $userType);
        $joins    = $this->getJoinList();

        if (array_key_exists($sortColumn, $sections)) {
            $section = $sections[$sortColumn];
            unset($sections[$sortColumn]);
        } else {
            $section = ['order' => ''];
        }

        $selectList = [
            'p.patientid',
            'summary.vob',
            'summary.ledger AS ledger',
            'summary.patient_info AS patient_info',
        ];

        $tableList = [
            'dental_patients p'
        ];

        $joinList = [
            'summary'
        ];

        $orderBy = $section['order'];

        if ($sortColumn === 'name') {

        } else {
            $orderBy = "patient_info DESC, "
                . ($orderBy ? $orderBy . ", " : "")
                . "p.lastname ASC, p.firstname ASC";
        }

        $orderBy = str_replace('%DIR%', $sortDir, $orderBy);

        if (isset($section['select'])) {
            $selectList[] = $section['select'];
        }

        if (isset($section['join'])) {
            $joinList[] = $section['join'];
        }

        foreach ($joinList as $name) {
            $tableList[] = array_get($joins, $name);
            unset($joins[$name]);
        }

        $selections = join(', ', $selectList);
        $tables = join(' ', $tableList);
        $offset = $pageNumber * $patientsPerPage;

        $countQuery = $this->select(DB::raw('COUNT(p.patientid) AS total'))
            ->from(DB::raw($tables));

        $countQuery  = $this->getConditions($countQuery, $type, $docId, $patientId, $letter);
        $countResult = $countQuery->get();

        $orderQuery = $this->select(DB::raw($selections))
            ->from(DB::raw($tables));

        $orderQuery  = $this->getConditions($orderQuery, $type, $docId, $patientId, $letter);
        $orderResults = $orderQuery->orderByRaw($orderBy)
            ->skip($offset)
            ->take($patientsPerPage)
            ->get();

        $selectList = array_merge($selectList, array_filter(array_pluck($sections, 'select')), ['p.*']);
        $tableList = array_merge($tableList, $joins);

        $patientIds = [];

        if ($orderResults) {
            $patientIds = array_pluck($orderResults, 'patientid');
        }

        $selections = join(",\n", $selectList);
        $tables = join("\n", $tableList);

        $results = $this->select(DB::raw($selections))
            ->from(DB::raw($tables));

        $results = $this->getConditions($results, $type, $docId, $patientId, $letter, $patientIds);
        $results = $results->orderByRaw($orderBy)
            ->take($patientsPerPage)
            ->get();

        return [
            'count'   => $countResult,
            'order'   => $orderResults,
            'results' => $results
        ];
    }

    private function getConditions(
        $query,
        $type,
        $docId      = 0,
        $patientId  = 0,
        $letter     = '',
        $patientIds = []
    ) {
        $query = $query->where('p.docid', $docId);

        if (!empty($patientId)) {
            $query = $query->where('p.patientid', $patientId);
        }

        switch ($type) {
            case 1:
                $query = $query->active();
                break;
            case 2:
                $query = $query->all();
                break;
            case 3:
                $query = $query->inactive();
                break;
            default:
                break;
        }

        if (!empty($letter)) {
            $query = $query->where('p.lastname', 'like', $letter . '%');
        }

        if (!empty($patientIds)) {
            $query = $query->whereIn('p.patientid', $patientIds);
        }

        return $query;
    }

    private function getQuerySections($section = 'all', $userType)
    {
        $userTypeSoftware = 2;

        $querySections = [
            'name' => [
                'order' => "p.lastname %DIR%, p.firstname %DIR%",
            ],
            'tx' => [
                'select' => "(
                    (
                        '{$userType}' = '$userTypeSoftware'
                        AND COALESCE(p.p_m_dss_file, 0) != 0
                    )
                    OR COALESCE(p.p_m_dss_file, 0) = 1
                ) AS insurance_no_error,
                (
                    SELECT COUNT(id)
                    FROM dental_summ_sleeplab sleep_lab
                    WHERE sleep_lab.patiendid = p.patientid
                        AND COALESCE(sleep_lab.filename, '') != ''
                        AND COALESCE(sleep_lab.diagnosis, '') != ''
                        AND (
                            p.p_m_ins_type != '1'
                            OR (
                                COALESCE(sleep_lab.diagnosising_doc, '') != ''
                                AND COALESCE(sleep_lab.diagnosising_npi, '') != ''
                            )
                        )
                ) AS numsleepstudy",
                'order' => "(insurance_no_error AND numsleepstudy > 0) %DIR%",
            ],
            'next-visit' => [
                'select' => 'next_visit.date_scheduled AS date_scheduled',
                'join' => 'next-visit',
                'order' => "date_scheduled %DIR%",
            ],
            'last-visit' => [
                'select' => 'last_dates.date_completed AS date_completed',
                'join' => 'last-dates',
                'order' => "date_completed %DIR%",
            ],
            'last-treatment' => [
                'select' => 'last_dates.segmentid AS segmentid',
                'join' => 'last-dates',
                'order' => "segmentid %DIR%",
            ],
            'appliance' => [
                'select' => 'device.device AS device',
                'join' => 'device',
                'order' => "device %DIR%",
            ],
            'appliance-since' => [
                'select' => 'device_date.dentaldevice_date AS dentaldevice_date',
                'join' => 'device',
                'order' => "dentaldevice_date %DIR%",
            ],
            'vob' => [
                'select' => 'summary.vob AS vob',
                'join' => 'summary',
                'order' => "vob %DIR%",
            ],
            'rx-lomn' => [
                'select' => "CASE
                    WHEN LENGTH(COALESCE(rx_lomn.rxlomnrec, ''))
                        OR (
                            LENGTH(COALESCE(rx_lomn.lomnrec, '')) AND LENGTH(COALESCE(rx_lomn.rxrec, ''))
                        ) THEN 3
                    WHEN LENGTH(COALESCE(rx_lomn.rxrec, '')) THEN 2
                    WHEN LENGTH(COALESCE(rx_lomn.lomnrec, '')) THEN 1
                    ELSE 0
                END AS rx_lomn",
                'join' => 'rx-lomn',
                'order' => "rx_lomn %DIR%",
            ],
            'ledger' => [
                'select' => '(
                    COALESCE(
                        (
                            SELECT SUM(COALESCE(first.amount, 0)) AS total
                            FROM dental_ledger first
                            WHERE first.docid = p.docid
                                AND first.patientid = p.patientid
                                AND COALESCE(first.paid_amount, 0) = 0
                        ), 0
                    )
                    + COALESCE(
                        (
                            SELECT SUM(COALESCE(second.amount, 0)) - SUM(COALESCE(second.paid_amount, 0))
                            FROM dental_ledger second
                            WHERE second.docid = p.docid
                                AND second.patientid = p.patientid
                                AND second.paid_amount != 0
                        ), 0
                    )
                    - COALESCE(
                        (
                            SELECT SUM(COALESCE(third_payment.amount, 0))
                            FROM dental_ledger third
                                LEFT JOIN dental_ledger_payment third_payment ON third_payment.ledgerid = third.ledgerid
                            WHERE third.docid = p.docid
                                AND third.patientid = p.patientid
                                AND third_payment.amount != 0
                        ), 0
                    )
                ) AS total',
                'order' => "ledger IS NOT NULL %DIR%, total %DIR%",
            ],
        ];

        return $this->itemSelector($querySections, $section);
    }

    private function itemSelector ($array = [], $section = 'all')
    {
        if ($section === 'all') {
            return $array;
        }

        if ($section{0} === '^') {
            $section = substr($section, 1);
            unset($array[$section]);
            return $array;
        }

        return array_get($array, $section);
    }

    private function getJoinList($section = 'all')
    {
        $joinSections = [
            'allergens-check' => 'LEFT JOIN (
                SELECT patientid, MAX(q_page3id) AS max_id
                FROM dental_q_page3
                GROUP BY patientid
            ) allergens_check_pivot ON allergens_check_pivot.patientid = p.patientid
            LEFT JOIN dental_q_page3 allergens_check ON allergens_check.q_page3id = allergens_check_pivot.max_id',

            'summary' => 'LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid',

            'rx-lomn' => 'LEFT JOIN (
                SELECT pid AS patientid, MAX(id) AS max_id
                FROM dental_flow_pg1
                GROUP BY pid
            ) rx_lomn_pivot ON rx_lomn_pivot.patientid = p.patientid
            LEFT JOIN dental_flow_pg1 rx_lomn ON rx_lomn.id = rx_lomn_pivot.max_id',

            'next-visit' => 'LEFT JOIN (
                SELECT patientid, MAX(id) AS max_id
                FROM dental_flow_pg2_info
                WHERE appointment_type = 0
                GROUP BY patientid
            ) next_visit_pivot ON next_visit_pivot.patientid = p.patientid
            LEFT JOIN dental_flow_pg2_info next_visit ON next_visit.id = next_visit_pivot.max_id',

            'last-dates' => 'LEFT JOIN (
                SELECT base_last_dates.patientid, MAX(base_last_dates.id) AS max_id, base_last_dates.segmentid
                FROM dental_flow_pg2_info base_last_dates
                    INNER JOIN (
                        SELECT patientid, max(date_completed) AS max_date
                        FROM dental_flow_pg2_info
                        GROUP BY patientid
                    ) pivot_last_dates ON pivot_last_dates.patientid = base_last_dates.patientid
                        AND pivot_last_dates.max_date = base_last_dates.date_completed
                GROUP BY base_last_dates.patientid
            ) last_dates_pivot ON last_dates_pivot.patientid = p.patientid
            LEFT JOIN dental_flow_pg2_info last_dates ON last_dates.id = last_dates_pivot.max_id',

            'device' => 'LEFT JOIN (
                SELECT patientid, dentaldevice, MAX(ex_page5id) AS max_id
                FROM dental_ex_page5
                GROUP BY patientid
            ) device_pivot ON device_pivot.patientid = p.patientid
            LEFT JOIN dental_ex_page5 device_date ON device_date.ex_page5id = device_pivot.max_id
            LEFT JOIN dental_device device ON device.deviceid = device_pivot.dentaldevice',
        ];

        return $this->itemSelector($joinSections, $section);
    }

    public function getReferredByContact($contactId)
    {
        return $this->select('patientid', 'firstname', 'lastname')
            ->where(function($query) {
                $query->whereNull('parent_patientid')
                    ->orWhere('parent_patientid', '=', '');
            })
            ->where('referred_source', 2)
            ->where('referred_by', $contactId)
            ->get();
    }

    public function getByContact($contactId)
    {
        return $this->select('patientid', 'firstname', 'lastname')
            ->where(function($query) {
                $query->whereNull('parent_patientid')
                    ->orWhere('parent_patientid', '=', '');
            })->where(function($query) use ($contactId) {
                $query->where('docpcp', '=', $contactId)
                    ->orWhere('docent', '=', $contactId)
                    ->orWhere('docsleep', '=', $contactId)
                    ->orWhere('docdentist', '=', $contactId)
                    ->orWhere('docmdother', '=', $contactId)
                    ->orWhere('docmdother2', '=', $contactId)
                    ->orWhere('docmdother3', '=', $contactId);
            })->get();
    }

    /**
     * @param int $patientId
     * @param Patient|null $patientReferredSource
     * @return string
     */
    public function getPatientReferralIds($patientId = 0, Patient $patientReferredSource = null)
    {
        if (!empty($patientReferredSource) && $patientReferredSource->referred_source == 1) {
            $contactQuery = $this->select(DB::raw('GROUP_CONCAT(distinct pr.patientid) as ids'))
                ->from(DB::raw('dental_patients pr'))
                ->join(DB::raw('dental_patients p'), 'p.referred_by', '=', 'pr.patientid')
                ->where('p.patientid', $patientId)
                ->groupBy('p.referred_by')
                ->orderBy('pr.patientid');
        } elseif (!empty($patientReferredSource) && $patientReferredSource->referred_source == 2) {
            $contactQuery = $this->select(DB::raw('GROUP_CONCAT(distinct dental_contact.contactid) as ids'))
                ->join('dental_patients', 'dental_patients.referred_by', '=', 'dental_contact.contactid')
                ->join(DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dental_contact.contacttypeid')
                ->where('dental_patients.patientid', $patientId)
                ->where('ct.physician', '!=', 1)
                ->groupBy('dental_patients.referred_by')
                ->orderBy('dental_contact.contactid');
        }

        $contactidList = '';

        if (!empty($contactQuery)) {
            $contacts = $contactQuery->get();

            if (count($contacts)) {
                $contactidList = $contacts[0]->ids;
            }
        }

        return $contactidList;
    }

    public function updateChildrenPatients($parentPatientId = 0, $data = [])
    {
        $this->where('parent_patientid', $parentPatientId)
            ->update($data);
    }

    /**
     * Search for similar logins (it need for creation of an unique login)
     */
    public function getSimilarPatientLogin($login = '')
    {
        return $this->select('login')
            ->where('login', 'like', $login . '%')
            ->orderBy('login', 'desc')
            ->first();
    }

    public function updatePatient($patientId = 0, $data = [])
    {
        return $this->where('patientid', $patientId)
            ->update($data);
    }

    public function getReferrers($docId, $names)
    {
        $contacts = DB::table(DB::raw('dental_contact c'))
            ->select(
                'c.contactid',
                'c.lastname',
                'c.firstname',
                'c.middlename',
                DB::raw(self::DSS_REFERRED_PHYSICIAN),
                'ct.contacttype'
            )->leftJoin(DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->where(function($query) use ($names) {
                $query->where(function($query) use ($names) {
                    $query->where('lastname', 'like', $names[0] . '%')
                        ->orWhere('firstname', 'like', $names[0] . '%');
                })->where(function($query) {
                    $query->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%');
                });
            })->whereNull('merge_id')
            ->where('docid', $docId);

        return $this->select(
                'p.patientid',
                'p.lastname',
                'p.firstname',
                'p.middlename',
                DB::raw(self::DSS_REFERRED_PATIENT . ' AS referral_type'),
                DB::raw("'Patient' as label")
            )->from(DB::raw('dental_patients p'))
            ->leftJoin(DB::raw('dental_patient_summary s'), 'p.patientid', '=', 's.pid')
            ->leftJoin(DB::raw('dental_device d'), 's.appliance', '=', 'd.deviceid')
            ->where(function($query) use ($names) {
                $query->where(function($query) use ($names) {
                    $query->where('lastname', 'like', $names[0] . '%')
                        ->orWhere('firstname', 'like', $names[0] . '%');
                })->where(function($query) {
                    $query->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%');
                });
            })->where('docid', $docId)
            ->union($contacts)
            ->orderBy('lastname')
            ->get();
    }

    /**
     * @param int $patientId
     * @return Patient|null
     */
    public function getDentalDeviceTransactionCode($patientId)
    {
        /** @var Patient|null $transactionCode */
        $transactionCode = $this->select('tc.*')
            ->from(DB::raw('dental_patients p'))
            ->join(DB::raw('dental_transaction_code tc'), function($query) {
                $query->on('p.docid', '=', 'tc.docid')
                    ->where('tc.transaction_code', '=', 'E0486');
            })->where('p.patientid', $patientId)
            ->first();
        return $transactionCode;
    }

    /**
     * @param int $patientId
     * @return User|null
     */
    public function getUserInfo($patientId)
    {
        /** @var User|null $user */
        $user = $this->select('u.*')
            ->from(DB::raw('dental_patients p'))
            ->join(DB::raw('dental_users u'), 'p.docid', '=', 'u.userid')
            ->where('p.patientid', $patientId)
            ->where('u.npi', '!=', '')
            ->whereNotNull('u.npi')
            ->where('u.tax_id_or_ssn', '!=', '')
            ->whereNotNull('u.tax_id_or_ssn')
            ->where(function($query) {
                $query->where('u.ssn', '=', 1)
                    ->orWhere('u.ein', '=', 1);
            })->first();
        return $user;
    }

    /**
     * @param int $patientId
     * @return Patient|null
     */
    public function getInsurancePreauthInfo($patientId)
    {
        /** @var Patient|null $preauthInfo */
        $preauthInfo = $this->select(
                'i.company as ins_co',
                "'primary' as ins_rank",
                'i.phone1 as ins_phone',
                'p.p_m_ins_grp as patient_ins_group_id',
                'p.p_m_ins_id as patient_ins_id',
                'p.firstname as patient_firstname',
                'p.lastname as patient_lastname',
                'p.add1 as patient_add1',
                'p.add2 as patient_add2',
                'p.city as patient_city',
                'p.state as patient_state',
                'p.zip as patient_zip',
                'p.dob as patient_dob',
                'p.p_m_partyfname as insured_first_name',
                'p.p_m_partylname as insured_last_name',
                'p.ins_dob as insured_dob',
                'd.npi as doc_npi',
                'r.national_provider_id as referring_doc_npi',
                'd.medicare_npi as doc_medicare_npi',
                'd.tax_id_or_ssn as doc_tax_id_or_ssn',
                "CONCAT(d.first_name, ' ', d.last_name) as doc_name",
                "CONCAT(d.address, ', ', d.city, ', ',d.state,' ',d.zip) as doc_address",
                'd.practice as doc_practice',
                'd.phone as doc_phone',
                'tc.amount as trxn_code_amount',
                'q2.confirmed_diagnosis as diagnosis_code',
                'd.userid as doc_id',
                'p.home_phone as patient_phone'
            )->from(DB::raw('dental_patients p'))
            ->leftJoin(DB::raw('dental_contact r'), 'p.referred_by', '=', 'r.contactid')
            ->join(DB::raw('dental_contact i'), 'p.p_m_ins_co', '=', 'i.contactid')
            ->join(DB::raw('dental_users d'), 'p.docid', '=', 'd.userid')
            ->join(DB::raw('dental_transaction_code tc'), function($query) {
                $query->on('p.docid', '=', 'tc.docid')
                    ->where('tc.transaction_code', '=', 'E0486');
            })->leftJoin(DB::raw('dental_q_page2 q2'), 'p.patientid', '=', 'q2.patientid')
            ->where('p.patientid', $patientId)
            ->first();
        return $preauthInfo;
    }

    /**
     * @param $letterId
     * @param $patient
     * @return \Illuminate\Database\Eloquent\Collection|Patient[]
     */
    public function getContactInfo($letterId, $patient)
    {
        return $this->select(
                'patientid AS id',
                'salutation',
                'firstname',
                'lastname',
                'add1',
                'add2',
                'city',
                'state',
                'zip',
                'email',
                'preferredcontact',
                DB::raw($letterId . ' AS letterid')
            )->whereIn('patientid', $patient)
            ->get();
    }

    /**
     * @param $letterId
     * @param $patReferralList
     * @return \Illuminate\Database\Eloquent\Collection|Patient[]
     */
    public function getReferralList($letterId, $patReferralList)
    {
        return $this->select(
                'p.patientid AS id',
                'p.salutation',
                'p.lastname',
                'p.middlename',
                'p.firstname',
                DB::raw("'' as company"),
                'p.add1',
                'p.add2',
                'p.city',
                'p.state',
                'p.zip',
                'p.email',
                DB::raw("'' as fax"),
                'p.preferredcontact',
                DB::raw("'' as contacttypeid"),
                DB::raw($letterId . ' AS letterid'),
                'p.status'
            )->from(DB::raw('dental_patients p'))
            ->whereIn('p.patientid', $patReferralList)
            ->get();
    }

    public function getSameEmails($email, $patientId)
    {
        return $this->select('patientid')
            ->where('email', $email)
            ->where(function($query) use ($patientId) {
                $query->where(function($query) use ($patientId) {
                    $query->where('patientid', '!=', $patientId)
                        ->where('parent_patientid', '!=', $patientId);
                })->orWhere(function($query) use ($patientId) {
                    $query->where('patientid', '!=', $patientId)
                        ->whereNull('parent_patientid');
                });
            })->count();
    }

    public function getPatientInfoWithDocInfo($patientId)
    {
        return $this->select('dp.*', 'du.use_patient_portal AS doc_use_patient_portal')
            ->from(DB::raw('dental_patients dp'))
            ->join(DB::raw('dental_users du'), 'du.userid', '=', 'dp.docid')
            ->where('dp.patientid', $patientId)
            ->first();
    }

    /**
     * @param int $docId
     * @param array $patientInfo
     * @return Patient[]
     */
    public function getSimilarPatients($docId, array $patientInfo)
    {
        $defaultPatientInfo = [
            'patient_id' => 0,
            'firstname'  => '',
            'lastname'   => '',
            'add1'       => '',
            'city'       => '',
            'state'      => '',
            'zip'        => ''
        ];

        $patientInfo = array_merge($defaultPatientInfo, $patientInfo);

        /** @var Patient[] $patients */
        $patients = $this->from(DB::raw('dental_patients p'))
            ->where('patientid', '!=', $patientInfo['patient_id'])
            ->where('docid', $docId)
            ->active()
            ->where(function($query) use ($patientInfo) {
                $query->where(function($query) use ($patientInfo) {
                    $query->where('firstname', '=', $patientInfo['firstname'])
                        ->where('lastname', '=', $patientInfo['lastname']);
                })->orWhere(function($query) use ($patientInfo) {
                    $query->where('add1', '=', $patientInfo['add1'])
                        ->where('add1', '!=', '')
                        ->where('city', '=', $patientInfo['city'])
                        ->where('city', '!=', '')
                        ->where('state', '=', $patientInfo['state'])
                        ->where('state', '!=', '')
                        ->where('zip', '=', $patientInfo['zip'])
                        ->where('zip', '!=', '');
                });
            })->get();
        return $patients;
    }

    public function getReferralCountersForContact($contactId, $contactType, $dateConditional, $isDetailed = false)
    {
        if ($isDetailed) {
            $query = $this->select('p.firstname', 'p.lastname', 'p.copyreqdate');
        } else {
            $query = $this->select('p.patientid');
        }

        $query = $query->from(DB::raw('dental_patients p'))
            ->where('p.referred_by', $contactId)
            ->where('p.referred_source', $contactType)
            ->whereRaw("STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') $dateConditional");

        if ($isDetailed) {
            return $query->get();
        } else {
            return $query->count();
        }
    }

    public function getRelatedToSleeplab($sleeplabId)
    {
        return $this->select('p.patientid', 'p.firstname', 'p.lastname')
            ->from(DB::raw('dental_patients p'))
            ->join(DB::raw('dental_summ_sleeplab s'), 's.patiendid', '=', 'p.patientid')
            ->where('s.place', $sleeplabId)
            ->groupBy('p.patientid')
            ->get();
    }
}

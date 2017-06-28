<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Insurance as Resource;
use DentalSleepSolutions\Contracts\Repositories\Insurances as Repository;
use DentalSleepSolutions\Libraries\ClaimFormData;
use DB;

/**
 * DentalSleepSolutions\Eloquent\Dental\Insurance
 *
 * @property int $insuranceid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $pica1
 * @property string|null $pica2
 * @property string|null $pica3
 * @property string|null $insurance_type
 * @property string|null $insured_id_number
 * @property string|null $patient_firstname
 * @property string|null $patient_lastname
 * @property string|null $patient_middle
 * @property string|null $patient_dob
 * @property string|null $patient_sex
 * @property string|null $insured_firstname
 * @property string|null $insured_lastname
 * @property string|null $insured_middle
 * @property string|null $patient_address
 * @property string|null $patient_relation_insured
 * @property string|null $insured_address
 * @property string|null $patient_city
 * @property string|null $patient_state
 * @property string|null $patient_status
 * @property string|null $insured_city
 * @property string|null $insured_state
 * @property string|null $patient_zip
 * @property string|null $patient_phone_code
 * @property string|null $patient_phone
 * @property string|null $insured_zip
 * @property string|null $insured_phone_code
 * @property string|null $insured_phone
 * @property string|null $other_insured_firstname
 * @property string|null $other_insured_lastname
 * @property string|null $other_insured_middle
 * @property string|null $employment
 * @property string|null $auto_accident
 * @property string|null $auto_accident_place
 * @property string|null $other_accident
 * @property string|null $insured_policy_group_feca
 * @property string|null $other_insured_policy_group_feca
 * @property string|null $insured_dob
 * @property string|null $insured_sex
 * @property string|null $other_insured_dob
 * @property string|null $other_insured_sex
 * @property string|null $insured_employer_school_name
 * @property string|null $other_insured_employer_school_name
 * @property string|null $insured_insurance_plan
 * @property string|null $other_insured_insurance_plan
 * @property string|null $reserved_local_use
 * @property string|null $another_plan
 * @property string|null $patient_signature
 * @property string|null $patient_signed_date
 * @property string|null $insured_signature
 * @property string|null $date_current
 * @property string|null $date_same_illness
 * @property string|null $unable_date_from
 * @property string|null $unable_date_to
 * @property string|null $referring_provider
 * @property string|null $field_17a_dd
 * @property string|null $field_17a
 * @property string|null $field_17b
 * @property string|null $hospitalization_date_from
 * @property string|null $hospitalization_date_to
 * @property string|null $reserved_local_use1
 * @property string|null $outside_lab
 * @property string|null $s_charges
 * @property string|null $diagnosis_1
 * @property string|null $diagnosis_2
 * @property string|null $diagnosis_3
 * @property string|null $diagnosis_4
 * @property string|null $medicaid_resubmission_code
 * @property string|null $original_ref_no
 * @property string|null $prior_authorization_number
 * @property string|null $service_date1_from
 * @property string|null $service_date1_to
 * @property string|null $place_of_service1
 * @property string|null $emg1
 * @property string|null $cpt_hcpcs1
 * @property string|null $modifier1_1
 * @property string|null $modifier1_2
 * @property string|null $modifier1_3
 * @property string|null $modifier1_4
 * @property string|null $diagnosis_pointer1
 * @property string|null $s_charges1_1
 * @property string|null $s_charges1_2
 * @property string|null $days_or_units1
 * @property string|null $epsdt_family_plan1
 * @property string|null $id_qua1
 * @property string|null $rendering_provider_id1
 * @property string|null $service_date2_from
 * @property string|null $service_date2_to
 * @property string|null $place_of_service2
 * @property string|null $emg2
 * @property string|null $cpt_hcpcs2
 * @property string|null $modifier2_1
 * @property string|null $modifier2_2
 * @property string|null $modifier2_3
 * @property string|null $modifier2_4
 * @property string|null $diagnosis_pointer2
 * @property string|null $s_charges2_1
 * @property string|null $s_charges2_2
 * @property string|null $days_or_units2
 * @property string|null $epsdt_family_plan2
 * @property string|null $id_qua2
 * @property string|null $rendering_provider_id2
 * @property string|null $service_date3_from
 * @property string|null $service_date3_to
 * @property string|null $place_of_service3
 * @property string|null $emg3
 * @property string|null $cpt_hcpcs3
 * @property string|null $modifier3_1
 * @property string|null $modifier3_2
 * @property string|null $modifier3_3
 * @property string|null $modifier3_4
 * @property string|null $diagnosis_pointer3
 * @property string|null $s_charges3_1
 * @property string|null $s_charges3_2
 * @property string|null $days_or_units3
 * @property string|null $epsdt_family_plan3
 * @property string|null $id_qua3
 * @property string|null $rendering_provider_id3
 * @property string|null $service_date4_from
 * @property string|null $service_date4_to
 * @property string|null $place_of_service4
 * @property string|null $emg4
 * @property string|null $cpt_hcpcs4
 * @property string|null $modifier4_1
 * @property string|null $modifier4_2
 * @property string|null $modifier4_3
 * @property string|null $modifier4_4
 * @property string|null $diagnosis_pointer4
 * @property string|null $s_charges4_1
 * @property string|null $s_charges4_2
 * @property string|null $days_or_units4
 * @property string|null $epsdt_family_plan4
 * @property string|null $id_qua4
 * @property string|null $rendering_provider_id4
 * @property string|null $service_date5_from
 * @property string|null $service_date5_to
 * @property string|null $place_of_service5
 * @property string|null $emg5
 * @property string|null $cpt_hcpcs5
 * @property string|null $modifier5_1
 * @property string|null $modifier5_2
 * @property string|null $modifier5_3
 * @property string|null $modifier5_4
 * @property string|null $diagnosis_pointer5
 * @property string|null $s_charges5_1
 * @property string|null $s_charges5_2
 * @property string|null $days_or_units5
 * @property string|null $epsdt_family_plan5
 * @property string|null $id_qua5
 * @property string|null $rendering_provider_id5
 * @property string|null $service_date6_from
 * @property string|null $service_date6_to
 * @property string|null $place_of_service6
 * @property string|null $emg6
 * @property string|null $cpt_hcpcs6
 * @property string|null $modifier6_1
 * @property string|null $modifier6_2
 * @property string|null $modifier6_3
 * @property string|null $modifier6_4
 * @property string|null $diagnosis_pointer6
 * @property string|null $s_charges6_1
 * @property string|null $s_charges6_2
 * @property string|null $days_or_units6
 * @property string|null $epsdt_family_plan6
 * @property string|null $id_qua6
 * @property string|null $rendering_provider_id6
 * @property string|null $federal_tax_id_number
 * @property string|null $ssn
 * @property string|null $ein
 * @property string|null $patient_account_no
 * @property string|null $accept_assignment
 * @property string|null $total_charge
 * @property string|null $amount_paid
 * @property string|null $balance_due
 * @property string|null $signature_physician
 * @property string|null $physician_signed_date
 * @property string|null $service_facility_info_name
 * @property string|null $service_facility_info_address
 * @property string|null $service_facility_info_city
 * @property string|null $service_info_a
 * @property string|null $service_info_dd
 * @property string|null $service_info_b_other
 * @property string|null $billing_provider_phone_code
 * @property string|null $billing_provider_phone
 * @property string|null $billing_provider_name
 * @property string|null $billing_provider_address
 * @property string|null $billing_provider_city
 * @property string|null $billing_provider_a
 * @property string|null $billing_provider_dd
 * @property string|null $billing_provider_b_other
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property int $card
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $dispute_reason
 * @property string|null $sec_dispute_reason
 * @property string|null $reject_reason
 * @property string|null $primary_fdf
 * @property string|null $secondary_fdf
 * @property int|null $producer
 * @property \Carbon\Carbon|null $mailed_date
 * @property string|null $eligible_response
 * @property string|null $p_m_eligible_payer_id
 * @property string|null $p_m_eligible_payer_name
 * @property \Carbon\Carbon|null $sec_mailed_date
 * @property int|null $other_insurance_type
 * @property string|null $patient_relation_other_insured
 * @property int|null $p_m_billing_id
 * @property int|null $p_m_dss_file
 * @property int|null $s_m_billing_id
 * @property int|null $s_m_dss_file
 * @property string|null $other_insured_address
 * @property string|null $other_insured_city
 * @property string|null $other_insured_state
 * @property string|null $other_insured_zip
 * @property string|null $eligible_token
 * @property \Carbon\Carbon|null $percase_date
 * @property string|null $percase_name
 * @property float|null $percase_amount
 * @property int|null $percase_status
 * @property int|null $percase_invoice
 * @property int|null $primary_claim_id
 * @property int|null $fo_paid_viewed
 * @property int|null $bo_paid_viewed
 * @property int|null $closed_by_office_type
 * @property string|null $s_m_eligible_payer_id
 * @property string|null $s_m_eligible_payer_name
 * @property string|null $other_insured_id_number
 * @property int|null $primary_claim_version
 * @property int|null $secondary_claim_version
 * @property string|null $nucc_8a
 * @property string|null $nucc_8b
 * @property string|null $nucc_9a
 * @property string|null $nucc_9b
 * @property string|null $nucc_9c
 * @property string|null $nucc_10d
 * @property string|null $nucc_30
 * @property string|null $claim_codes
 * @property string|null $other_claim_id
 * @property int|null $icd_ind
 * @property string|null $name_referring_provider_qualifier
 * @property string|null $diagnosis_a
 * @property string|null $diagnosis_b
 * @property string|null $diagnosis_c
 * @property string|null $diagnosis_d
 * @property string|null $diagnosis_e
 * @property string|null $diagnosis_f
 * @property string|null $diagnosis_g
 * @property string|null $diagnosis_h
 * @property string|null $diagnosis_i
 * @property string|null $diagnosis_j
 * @property string|null $diagnosis_k
 * @property string|null $diagnosis_l
 * @property string|null $current_qual
 * @property string|null $same_illness_qual
 * @property string|null $resubmission_code
 * @property int|null $resubmission_code_fill
 * @property string|null $responsibility_sequence
 * @property string|null $rendering_provider_entity_1
 * @property string|null $rendering_provider_first_name_1
 * @property string|null $rendering_provider_last_name_1
 * @property string|null $rendering_provider_org_1
 * @property string|null $rendering_provider_npi_1
 * @property string|null $rendering_provider_entity_2
 * @property string|null $rendering_provider_first_name_2
 * @property string|null $rendering_provider_last_name_2
 * @property string|null $rendering_provider_org_2
 * @property string|null $rendering_provider_npi_2
 * @property string|null $rendering_provider_entity_3
 * @property string|null $rendering_provider_first_name_3
 * @property string|null $rendering_provider_last_name_3
 * @property string|null $rendering_provider_org_3
 * @property string|null $rendering_provider_npi_3
 * @property string|null $rendering_provider_entity_4
 * @property string|null $rendering_provider_first_name_4
 * @property string|null $rendering_provider_last_name_4
 * @property string|null $rendering_provider_org_4
 * @property string|null $rendering_provider_npi_4
 * @property string|null $rendering_provider_entity_5
 * @property string|null $rendering_provider_first_name_5
 * @property string|null $rendering_provider_last_name_5
 * @property string|null $rendering_provider_org_5
 * @property string|null $rendering_provider_npi_5
 * @property string|null $rendering_provider_entity_6
 * @property string|null $rendering_provider_first_name_6
 * @property string|null $rendering_provider_last_name_6
 * @property string|null $rendering_provider_org_6
 * @property string|null $rendering_provider_npi_6
 * @property string|null $payer_id
 * @property string|null $payer_name
 * @property string|null $payer_address
 * @property string|null $payer_city
 * @property string|null $payer_state
 * @property string|null $payer_zip
 * @property string|null $billing_provider_taxonomy_code
 * @property string|null $other_insured_insurance_type
 * @property string|null $claim_info_code
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance countFrontOfficeClaims($docId = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance pending()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance rejected()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAcceptAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAnotherPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAutoAccident($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAutoAccidentPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBalanceDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderBOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderDd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderPhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderTaxonomyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBoPaidViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereClaimCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereClaimInfoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereClosedByOfficeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCurrentQual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDateCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDateSameIllness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDisputeReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEligibleResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEligibleToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmployment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereFederalTaxIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereField17a($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereField17aDd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereField17b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereFoPaidViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereHospitalizationDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereHospitalizationDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIcdInd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuranceid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredMiddle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredPhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereMailedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereMedicaidResubmissionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier13($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier14($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier22($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier23($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier24($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier31($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier32($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier33($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier34($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier41($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier42($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier43($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier44($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier51($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier52($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier53($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier54($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier61($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier62($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier63($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier64($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNameReferringProviderQualifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc10d($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc30($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc8a($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc8b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc9a($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc9b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc9c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOriginalRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherAccident($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredMiddle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOutsideLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMDssFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMEligiblePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMEligiblePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientMiddle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientPhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientRelationInsured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientRelationOtherInsured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientSignedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePhysicianSignedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePica1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePica2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePica3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePrimaryClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePrimaryClaimVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePrimaryFdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePriorAuthorizationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereReferringProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereReservedLocalUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereReservedLocalUse1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereResponsibilitySequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereResubmissionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereResubmissionCodeFill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges22($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges31($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges32($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges41($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges42($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges51($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges52($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges61($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges62($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMDssFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMEligiblePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMEligiblePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSameIllnessQual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecDisputeReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecMailedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecondaryClaimVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecondaryFdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate1From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate1To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate2From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate2To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate3From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate3To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate4From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate4To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate5From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate5To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate6From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate6To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceFacilityInfoAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceFacilityInfoCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceFacilityInfoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceInfoA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceInfoBOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceInfoDd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSignaturePhysician($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereTotalCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereUnableDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereUnableDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereUserid($value)
 * @mixin \Eloquent
 */
class Insurance extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    // Claim statuses (insurance)
    const DSS_CLAIM_PENDING = 0;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['insuranceid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_insurance';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'insuranceid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['mailed_date', 'sec_mailed_date', 'percase_date'];

    private $claimStatuses = [
        'DSS_CLAIM_PENDING'             => 0,
        'DSS_CLAIM_SENT'                => 1,
        'DSS_CLAIM_DISPUTE'             => 2,
        'DSS_CLAIM_PAID_INSURANCE'      => 3,
        'DSS_CLAIM_REJECTED'            => 4,
        'DSS_CLAIM_PAID_PATIENT'        => 5,
        'DSS_CLAIM_SEC_PENDING'         => 6,
        'DSS_CLAIM_SEC_SENT'            => 7,
        'DSS_CLAIM_SEC_DISPUTE'         => 8,
        'DSS_CLAIM_PAID_SEC_INSURANCE'  => 9,
        'DSS_CLAIM_PATIENT_DISPUTE'     => 10,
        'DSS_CLAIM_PAID_SEC_PATIENT'    => 11,
        'DSS_CLAIM_SEC_PATIENT_DISPUTE' => 12,
        'DSS_CLAIM_SEC_REJECTED'        => 13,
        'DSS_CLAIM_EFILE_ACCEPTED'      => 14,
        'DSS_CLAIM_SEC_EFILE_ACCEPTED'  => 15
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    private function filedByBackOfficeConditional($claimAlias = 'claim')
    {
        return "(
                -- Filed by back office, legacy logic
                COALESCE(IF($claimAlias.primary_claim_id, $claimAlias.s_m_dss_file, $claimAlias.p_m_dss_file), 0) = 1
                -- Filed by back office, new logic
                OR COALESCE($claimAlias.p_m_dss_file, 0) = 3
            )";
    }

    private function backOfficeClaimsConditional($aliases = [])
    {
        $actionableStatusList = "'" . implode("', '", ClaimFormData::statusListByName('actionable')) . "'";
        $pendingStatusList    = "'" . implode("', '", ClaimFormData::statusListByName('pending')) . "'";

        $claimAlias   = array_get($aliases, 'claim', 'claim');
        $patientAlias = array_get($aliases, 'patient', 'p');
        $companyAlias = array_get($aliases, 'company', 'c');

        $filedByBackOfficeConditional = $this->filedByBackOfficeConditional($claimAlias);

        return "(
            -- Apply claim options only if the status is NOT pending
            (
                $claimAlias.status NOT IN ($pendingStatusList)
                AND $filedByBackOfficeConditional
            )
            OR (
                $claimAlias.status IN ($actionableStatusList)
                AND (
                    -- Doctor BO exclusivity
                    COALESCE($companyAlias.exclusive, 0)
                    -- Patient's BO filing permission
                    OR COALESCE(IF($claimAlias.primary_claim_id, $patientAlias.s_m_dss_file, $patientAlias.p_m_dss_file), 0) = 1
                )
            )
        )";
    }

    private function frontOfficeClaimsConditional($aliases = [])
    {
        return '(NOT ' . $this->backOfficeClaimsConditional($aliases) . ')';
    }

    public function scopeRejected($globalQuery)
    {
        return $globalQuery->where(function($query) {
            return $query->where('status', $this->claimStatuses['DSS_CLAIM_REJECTED'])
                ->orWhere('status', $this->claimStatuses['DSS_CLAIM_SEC_REJECTED']);
        });
    }

    public function scopeFiledByBackOfficeConditional($query, $claimAlias='claim')
    {
        // Filed by back office, legacy logic
        return $query->whereRaw("COALESCE(IF($claimAlias.primary_claim_id, $claimAlias.s_m_dss_file, $claimAlias.p_m_dss_file), 0) = 1")
            // Filed by back office, new logic
            ->orWhereRaw("COALESCE($claimAlias.p_m_dss_file, 0) = 3");
    }

    public function scopeCountFrontOfficeClaims($query, $docId = 0)
    {
        return $query->from(DB::raw('dental_insurance claim'))
            ->select(DB::raw('COUNT(claim.insuranceid) AS total'))
            ->leftJoin(DB::raw('dental_patients patient'), 'patient.patientid', '=', 'claim.patientid')
            ->join(DB::raw('dental_users users'), 'claim.docid', '=', 'users.userid')
            ->leftJoin(DB::raw('companies company'), 'company.id', '=', 'users.billing_company_id')
            ->whereRaw($this->frontOfficeClaimsConditional(['company' => 'company', 'patient' => 'patient']))
            ->where('claim.docid', $docId);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::DSS_CLAIM_PENDING);
    }

    public function getRejected($patientId = 0)
    {
        return $this->rejected()
            ->where('patientid', $patientId)
            ->get();
    }

    public function getPendingClaims($docId = 0)
    {
        return $this->countFrontOfficeClaims($docId)
            ->whereIn('claim.status', ClaimFormData::statusListByName('actionable'))
            ->first();
    }

    public function getUnmailedClaims($docId = 0, $isUserTypeSoftware = false)
    {
        $query = $this->countFrontOfficeClaims($docId)
            ->whereNull('claim.mailed_date')
            ->whereNull('claim.sec_mailed_date');

        if ($isUserTypeSoftware) {
            $query = $query->whereNotIn('claim.status', ClaimFormData::statusListByName('actionable'));
        }

        return $query->first();
    }

    public function getRejectedClaims($docId = 0)
    {
        return $this->countFrontOfficeClaims($docId)
            ->whereIn('claim.status', ClaimFormData::statusListByName('rejected'))
            ->first();
    }

    public function getOpenClaims($patientId, $page, $rowsPerPage, $sort, $sortDir)
    {
        $query = $this->select(
                'i.patientid',
                'i.docid',
                DB::raw("'claim'"),
                'i.insuranceid AS ledgerid',
                'i.adddate AS service_date',
                'i.adddate AS entry_date',
                DB::raw("'Claim' AS name"),
                DB::raw("'Insurance Claim' AS description"),
                DB::raw('(
                            SELECT SUM(dl2.amount)
                            FROM dental_ledger dl2
                                INNER JOIN dental_insurance i2 ON dl2.primary_claim_id = i2.insuranceid
                            WHERE i2.insuranceid = i.insuranceid
                        ) AS amount'),
                DB::raw('SUM(pay.amount) AS paid_amount'),
                'i.status',
                'i.insuranceid AS primary_claim_id',
                'i.mailed_date',
                DB::raw($this->filedByBackOfficeConditional($claimAlias = 'i') . ' as filed_by_bo')
            )->from(DB::raw('dental_insurance i'))
            ->leftJoin(DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->where('i.patientid', $patientId)
            ->whereNotIn('i.status', [
                $this->claimStatuses['DSS_CLAIM_PAID_INSURANCE'],
                $this->claimStatuses['DSS_CLAIM_PAID_SEC_INSURANCE'],
                $this->claimStatuses['DSS_CLAIM_PAID_PATIENT']
            ])->groupBy('i.insuranceid')
            ->orderBy($this->getSortColumnForList($sort), $sortDir)
            ->skip($page * $rowsPerPage)
            ->take($rowsPerPage);

        return $query->get();
    }

    public function getLedgerDetailsQuery($patientId)
    {
        return $this->select(
            'i.patientid',
            'i.docid',
            DB::raw("'claim'"),
            'i.insuranceid',
            'i.adddate',
            'i.adddate',
            DB::raw("'Claim'"),
            DB::raw("'Insurance Claim'"),
            DB::raw('(
                SELECT SUM(dl2.amount)
                FROM dental_ledger dl2
                    INNER JOIN dental_insurance i2 ON dl2.primary_claim_id = i2.insuranceid
                WHERE i2.insuranceid = i.insuranceid)'),
            DB::raw('SUM(pay.amount)'),
            'i.status',
            'i.primary_claim_id',
            'i.mailed_date',
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw('(
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = i.insuranceid)'),
            DB::raw("(
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = i.insuranceid
                    AND create_type = '1')"),
            DB::raw($this->filedByBackOfficeConditional($claimAlias = 'i') . ' as filed_by_bo')
        )->from(DB::raw('dental_insurance i'))
        ->leftJoin(DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
        ->leftJoin(DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
        ->where('i.patientid', $patientId)
        ->groupBy('i.insuranceid');
    }

    public function getLedgerDetailsRowsNumber($patientId)
    {
        $subQuery = $this->select('i.insuranceid')
            ->from(DB::raw('dental_insurance i'))
            ->leftJoin(DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->whereRaw('i.patientid = ?', [$patientId])
            ->groupBy('i.insuranceid');

        $subQueryString = $subQuery->toSql();

        $query = $this->select(DB::raw('COUNT(insuranceid) as number'))
            ->from(DB::raw("($subQueryString) as test"))
            ->mergeBindings($subQuery->getQuery())
            ->first();

        return !empty($query) ? $query->number : 0;
    }

    public function removePendingClaim($claimId)
    {
        return $this->where('insuranceid', $claimId)
            ->pending()
            ->delete();
    }

    private function getSortColumnForList($sort)
    {
        $sortColumns = [
            'entry_date'  => 'entry_date',
            'producer'    => 'name',
            'patient'     => 'lastname',
            'description' => 'description',
            'amount'      => 'amount',
            'paid_amount' => 'paid_amount',
            'status'      => 'status'
        ];

        if (array_key_exists($sort, $sortColumns)) {
            $sortColumn = $sortColumns[$sort];
        } else {
            $sortColumn = 'service_date';
        }

        return $sortColumn;
    }
}

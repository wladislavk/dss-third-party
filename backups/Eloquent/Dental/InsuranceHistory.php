<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\InsuranceHistory as Resource;
use DentalSleepSolutions\Contracts\Repositories\InsuranceHistories as Repository;

/**
 * @SWG\Definition(
 *     definition="InsuranceHistory",
 *     type="object",
 *     required={"insuranceid", "card", "id"},
 *     @SWG\Property(property="insuranceid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="pica1", type="string"),
 *     @SWG\Property(property="pica2", type="string"),
 *     @SWG\Property(property="pica3", type="string"),
 *     @SWG\Property(property="insurance_type", type="string"),
 *     @SWG\Property(property="insured_id_number", type="string"),
 *     @SWG\Property(property="patient_firstname", type="string"),
 *     @SWG\Property(property="patient_lastname", type="string"),
 *     @SWG\Property(property="patient_middle", type="string"),
 *     @SWG\Property(property="patient_dob", type="string"),
 *     @SWG\Property(property="patient_sex", type="string"),
 *     @SWG\Property(property="insured_firstname", type="string"),
 *     @SWG\Property(property="insured_lastname", type="string"),
 *     @SWG\Property(property="insured_middle", type="string"),
 *     @SWG\Property(property="patient_address", type="string"),
 *     @SWG\Property(property="patient_relation_insured", type="string"),
 *     @SWG\Property(property="insured_address", type="string"),
 *     @SWG\Property(property="patient_city", type="string"),
 *     @SWG\Property(property="patient_state", type="string"),
 *     @SWG\Property(property="patient_status", type="string"),
 *     @SWG\Property(property="insured_city", type="string"),
 *     @SWG\Property(property="insured_state", type="string"),
 *     @SWG\Property(property="patient_zip", type="string"),
 *     @SWG\Property(property="patient_phone_code", type="string"),
 *     @SWG\Property(property="patient_phone", type="string"),
 *     @SWG\Property(property="insured_zip", type="string"),
 *     @SWG\Property(property="insured_phone_code", type="string"),
 *     @SWG\Property(property="insured_phone", type="string"),
 *     @SWG\Property(property="other_insured_firstname", type="string"),
 *     @SWG\Property(property="other_insured_lastname", type="string"),
 *     @SWG\Property(property="other_insured_middle", type="string"),
 *     @SWG\Property(property="employment", type="string"),
 *     @SWG\Property(property="auto_accident", type="string"),
 *     @SWG\Property(property="auto_accident_place", type="string"),
 *     @SWG\Property(property="other_accident", type="string"),
 *     @SWG\Property(property="insured_policy_group_feca", type="string"),
 *     @SWG\Property(property="other_insured_policy_group_feca", type="string"),
 *     @SWG\Property(property="insured_dob", type="string"),
 *     @SWG\Property(property="insured_sex", type="string"),
 *     @SWG\Property(property="other_insured_dob", type="string"),
 *     @SWG\Property(property="other_insured_sex", type="string"),
 *     @SWG\Property(property="insured_employer_school_name", type="string"),
 *     @SWG\Property(property="other_insured_employer_school_name", type="string"),
 *     @SWG\Property(property="insured_insurance_plan", type="string"),
 *     @SWG\Property(property="other_insured_insurance_plan", type="string"),
 *     @SWG\Property(property="reserved_local_use", type="string"),
 *     @SWG\Property(property="another_plan", type="string"),
 *     @SWG\Property(property="patient_signature", type="string"),
 *     @SWG\Property(property="patient_signed_date", type="string"),
 *     @SWG\Property(property="insured_signature", type="string"),
 *     @SWG\Property(property="date_current", type="string"),
 *     @SWG\Property(property="date_same_illness", type="string"),
 *     @SWG\Property(property="unable_date_from", type="string"),
 *     @SWG\Property(property="unable_date_to", type="string"),
 *     @SWG\Property(property="referring_provider", type="string"),
 *     @SWG\Property(property="field_17a_dd", type="string"),
 *     @SWG\Property(property="field_17a", type="string"),
 *     @SWG\Property(property="field_17b", type="string"),
 *     @SWG\Property(property="hospitalization_date_from", type="string"),
 *     @SWG\Property(property="hospitalization_date_to", type="string"),
 *     @SWG\Property(property="reserved_local_use1", type="string"),
 *     @SWG\Property(property="outside_lab", type="string"),
 *     @SWG\Property(property="s_charges", type="string"),
 *     @SWG\Property(property="diagnosis_1", type="string"),
 *     @SWG\Property(property="diagnosis_2", type="string"),
 *     @SWG\Property(property="diagnosis_3", type="string"),
 *     @SWG\Property(property="diagnosis_4", type="string"),
 *     @SWG\Property(property="medicaid_resubmission_code", type="string"),
 *     @SWG\Property(property="original_ref_no", type="string"),
 *     @SWG\Property(property="prior_authorization_number", type="string"),
 *     @SWG\Property(property="service_date1_from", type="string"),
 *     @SWG\Property(property="service_date1_to", type="string"),
 *     @SWG\Property(property="place_of_service1", type="string"),
 *     @SWG\Property(property="emg1", type="string"),
 *     @SWG\Property(property="cpt_hcpcs1", type="string"),
 *     @SWG\Property(property="modifier1_1", type="string"),
 *     @SWG\Property(property="modifier1_2", type="string"),
 *     @SWG\Property(property="modifier1_3", type="string"),
 *     @SWG\Property(property="modifier1_4", type="string"),
 *     @SWG\Property(property="diagnosis_pointer1", type="string"),
 *     @SWG\Property(property="s_charges1_1", type="string"),
 *     @SWG\Property(property="s_charges1_2", type="string"),
 *     @SWG\Property(property="days_or_units1", type="string"),
 *     @SWG\Property(property="epsdt_family_plan1", type="string"),
 *     @SWG\Property(property="id_qua1", type="string"),
 *     @SWG\Property(property="rendering_provider_id1", type="string"),
 *     @SWG\Property(property="service_date2_from", type="string"),
 *     @SWG\Property(property="service_date2_to", type="string"),
 *     @SWG\Property(property="place_of_service2", type="string"),
 *     @SWG\Property(property="emg2", type="string"),
 *     @SWG\Property(property="cpt_hcpcs2", type="string"),
 *     @SWG\Property(property="modifier2_1", type="string"),
 *     @SWG\Property(property="modifier2_2", type="string"),
 *     @SWG\Property(property="modifier2_3", type="string"),
 *     @SWG\Property(property="modifier2_4", type="string"),
 *     @SWG\Property(property="diagnosis_pointer2", type="string"),
 *     @SWG\Property(property="s_charges2_1", type="string"),
 *     @SWG\Property(property="s_charges2_2", type="string"),
 *     @SWG\Property(property="days_or_units2", type="string"),
 *     @SWG\Property(property="epsdt_family_plan2", type="string"),
 *     @SWG\Property(property="id_qua2", type="string"),
 *     @SWG\Property(property="rendering_provider_id2", type="string"),
 *     @SWG\Property(property="service_date3_from", type="string"),
 *     @SWG\Property(property="service_date3_to", type="string"),
 *     @SWG\Property(property="place_of_service3", type="string"),
 *     @SWG\Property(property="emg3", type="string"),
 *     @SWG\Property(property="cpt_hcpcs3", type="string"),
 *     @SWG\Property(property="modifier3_1", type="string"),
 *     @SWG\Property(property="modifier3_2", type="string"),
 *     @SWG\Property(property="modifier3_3", type="string"),
 *     @SWG\Property(property="modifier3_4", type="string"),
 *     @SWG\Property(property="diagnosis_pointer3", type="string"),
 *     @SWG\Property(property="s_charges3_1", type="string"),
 *     @SWG\Property(property="s_charges3_2", type="string"),
 *     @SWG\Property(property="days_or_units3", type="string"),
 *     @SWG\Property(property="epsdt_family_plan3", type="string"),
 *     @SWG\Property(property="id_qua3", type="string"),
 *     @SWG\Property(property="rendering_provider_id3", type="string"),
 *     @SWG\Property(property="service_date4_from", type="string"),
 *     @SWG\Property(property="service_date4_to", type="string"),
 *     @SWG\Property(property="place_of_service4", type="string"),
 *     @SWG\Property(property="emg4", type="string"),
 *     @SWG\Property(property="cpt_hcpcs4", type="string"),
 *     @SWG\Property(property="modifier4_1", type="string"),
 *     @SWG\Property(property="modifier4_2", type="string"),
 *     @SWG\Property(property="modifier4_3", type="string"),
 *     @SWG\Property(property="modifier4_4", type="string"),
 *     @SWG\Property(property="diagnosis_pointer4", type="string"),
 *     @SWG\Property(property="s_charges4_1", type="string"),
 *     @SWG\Property(property="s_charges4_2", type="string"),
 *     @SWG\Property(property="days_or_units4", type="string"),
 *     @SWG\Property(property="epsdt_family_plan4", type="string"),
 *     @SWG\Property(property="id_qua4", type="string"),
 *     @SWG\Property(property="rendering_provider_id4", type="string"),
 *     @SWG\Property(property="service_date5_from", type="string"),
 *     @SWG\Property(property="service_date5_to", type="string"),
 *     @SWG\Property(property="place_of_service5", type="string"),
 *     @SWG\Property(property="emg5", type="string"),
 *     @SWG\Property(property="cpt_hcpcs5", type="string"),
 *     @SWG\Property(property="modifier5_1", type="string"),
 *     @SWG\Property(property="modifier5_2", type="string"),
 *     @SWG\Property(property="modifier5_3", type="string"),
 *     @SWG\Property(property="modifier5_4", type="string"),
 *     @SWG\Property(property="diagnosis_pointer5", type="string"),
 *     @SWG\Property(property="s_charges5_1", type="string"),
 *     @SWG\Property(property="s_charges5_2", type="string"),
 *     @SWG\Property(property="days_or_units5", type="string"),
 *     @SWG\Property(property="epsdt_family_plan5", type="string"),
 *     @SWG\Property(property="id_qua5", type="string"),
 *     @SWG\Property(property="rendering_provider_id5", type="string"),
 *     @SWG\Property(property="service_date6_from", type="string"),
 *     @SWG\Property(property="service_date6_to", type="string"),
 *     @SWG\Property(property="place_of_service6", type="string"),
 *     @SWG\Property(property="emg6", type="string"),
 *     @SWG\Property(property="cpt_hcpcs6", type="string"),
 *     @SWG\Property(property="modifier6_1", type="string"),
 *     @SWG\Property(property="modifier6_2", type="string"),
 *     @SWG\Property(property="modifier6_3", type="string"),
 *     @SWG\Property(property="modifier6_4", type="string"),
 *     @SWG\Property(property="diagnosis_pointer6", type="string"),
 *     @SWG\Property(property="s_charges6_1", type="string"),
 *     @SWG\Property(property="s_charges6_2", type="string"),
 *     @SWG\Property(property="days_or_units6", type="string"),
 *     @SWG\Property(property="epsdt_family_plan6", type="string"),
 *     @SWG\Property(property="id_qua6", type="string"),
 *     @SWG\Property(property="rendering_provider_id6", type="string"),
 *     @SWG\Property(property="federal_tax_id_number", type="string"),
 *     @SWG\Property(property="ssn", type="string"),
 *     @SWG\Property(property="ein", type="string"),
 *     @SWG\Property(property="patient_account_no", type="string"),
 *     @SWG\Property(property="accept_assignment", type="string"),
 *     @SWG\Property(property="total_charge", type="string"),
 *     @SWG\Property(property="amount_paid", type="string"),
 *     @SWG\Property(property="balance_due", type="string"),
 *     @SWG\Property(property="signature_physician", type="string"),
 *     @SWG\Property(property="physician_signed_date", type="string"),
 *     @SWG\Property(property="service_facility_info_name", type="string"),
 *     @SWG\Property(property="service_facility_info_address", type="string"),
 *     @SWG\Property(property="service_facility_info_city", type="string"),
 *     @SWG\Property(property="service_info_a", type="string"),
 *     @SWG\Property(property="service_info_dd", type="string"),
 *     @SWG\Property(property="service_info_b_other", type="string"),
 *     @SWG\Property(property="billing_provider_phone_code", type="string"),
 *     @SWG\Property(property="billing_provider_phone", type="string"),
 *     @SWG\Property(property="billing_provider_name", type="string"),
 *     @SWG\Property(property="billing_provider_address", type="string"),
 *     @SWG\Property(property="billing_provider_city", type="string"),
 *     @SWG\Property(property="billing_provider_a", type="string"),
 *     @SWG\Property(property="billing_provider_dd", type="string"),
 *     @SWG\Property(property="billing_provider_b_other", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="card", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="dispute_reason", type="string"),
 *     @SWG\Property(property="sec_dispute_reason", type="string"),
 *     @SWG\Property(property="reject_reason", type="string"),
 *     @SWG\Property(property="primary_fdf", type="string"),
 *     @SWG\Property(property="secondary_fdf", type="string"),
 *     @SWG\Property(property="producer", type="integer"),
 *     @SWG\Property(property="mailed_date", type="string", format="dateTime"),
 *     @SWG\Property(property="eligible_response", type="string"),
 *     @SWG\Property(property="p_m_eligible_payer_id", type="string"),
 *     @SWG\Property(property="p_m_eligible_payer_name", type="string"),
 *     @SWG\Property(property="sec_mailed_date", type="string", format="dateTime"),
 *     @SWG\Property(property="other_insurance_type", type="integer"),
 *     @SWG\Property(property="patient_relation_other_insured", type="string"),
 *     @SWG\Property(property="p_m_billing_id", type="integer"),
 *     @SWG\Property(property="p_m_dss_file", type="integer"),
 *     @SWG\Property(property="s_m_billing_id", type="integer"),
 *     @SWG\Property(property="s_m_dss_file", type="integer"),
 *     @SWG\Property(property="other_insured_address", type="string"),
 *     @SWG\Property(property="other_insured_city", type="string"),
 *     @SWG\Property(property="other_insured_state", type="string"),
 *     @SWG\Property(property="other_insured_zip", type="string"),
 *     @SWG\Property(property="eligible_token", type="string"),
 *     @SWG\Property(property="percase_date", type="string", format="dateTime"),
 *     @SWG\Property(property="percase_name", type="string"),
 *     @SWG\Property(property="percase_amount", type="float"),
 *     @SWG\Property(property="percase_status", type="integer"),
 *     @SWG\Property(property="percase_invoice", type="integer"),
 *     @SWG\Property(property="primary_claim_id", type="integer"),
 *     @SWG\Property(property="fo_paid_viewed", type="integer"),
 *     @SWG\Property(property="bo_paid_viewed", type="integer"),
 *     @SWG\Property(property="closed_by_office_type", type="integer"),
 *     @SWG\Property(property="s_m_eligible_payer_id", type="string"),
 *     @SWG\Property(property="s_m_eligible_payer_name", type="string"),
 *     @SWG\Property(property="other_insured_id_number", type="string"),
 *     @SWG\Property(property="primary_claim_version", type="integer"),
 *     @SWG\Property(property="secondary_claim_version", type="integer"),
 *     @SWG\Property(property="nucc_8a", type="string"),
 *     @SWG\Property(property="nucc_8b", type="string"),
 *     @SWG\Property(property="nucc_9a", type="string"),
 *     @SWG\Property(property="nucc_9b", type="string"),
 *     @SWG\Property(property="nucc_9c", type="string"),
 *     @SWG\Property(property="nucc_10d", type="string"),
 *     @SWG\Property(property="nucc_30", type="string"),
 *     @SWG\Property(property="claim_codes", type="string"),
 *     @SWG\Property(property="other_claim_id", type="string"),
 *     @SWG\Property(property="icd_ind", type="integer"),
 *     @SWG\Property(property="name_referring_provider_qualifier", type="string"),
 *     @SWG\Property(property="diagnosis_a", type="string"),
 *     @SWG\Property(property="diagnosis_b", type="string"),
 *     @SWG\Property(property="diagnosis_c", type="string"),
 *     @SWG\Property(property="diagnosis_d", type="string"),
 *     @SWG\Property(property="diagnosis_e", type="string"),
 *     @SWG\Property(property="diagnosis_f", type="string"),
 *     @SWG\Property(property="diagnosis_g", type="string"),
 *     @SWG\Property(property="diagnosis_h", type="string"),
 *     @SWG\Property(property="diagnosis_i", type="string"),
 *     @SWG\Property(property="diagnosis_j", type="string"),
 *     @SWG\Property(property="diagnosis_k", type="string"),
 *     @SWG\Property(property="diagnosis_l", type="string"),
 *     @SWG\Property(property="current_qual", type="string"),
 *     @SWG\Property(property="same_illness_qual", type="string"),
 *     @SWG\Property(property="resubmission_code", type="string"),
 *     @SWG\Property(property="resubmission_code_fill", type="integer"),
 *     @SWG\Property(property="updated_by_user", type="integer"),
 *     @SWG\Property(property="updated_by_admin", type="integer"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime"),
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="responsibility_sequence", type="string"),
 *     @SWG\Property(property="rendering_provider_entity_1", type="string"),
 *     @SWG\Property(property="rendering_provider_first_name_1", type="string"),
 *     @SWG\Property(property="rendering_provider_last_name_1", type="string"),
 *     @SWG\Property(property="rendering_provider_org_1", type="string"),
 *     @SWG\Property(property="rendering_provider_npi_1", type="string"),
 *     @SWG\Property(property="rendering_provider_entity_2", type="string"),
 *     @SWG\Property(property="rendering_provider_first_name_2", type="string"),
 *     @SWG\Property(property="rendering_provider_last_name_2", type="string"),
 *     @SWG\Property(property="rendering_provider_org_2", type="string"),
 *     @SWG\Property(property="rendering_provider_npi_2", type="string"),
 *     @SWG\Property(property="rendering_provider_entity_3", type="string"),
 *     @SWG\Property(property="rendering_provider_first_name_3", type="string"),
 *     @SWG\Property(property="rendering_provider_last_name_3", type="string"),
 *     @SWG\Property(property="rendering_provider_org_3", type="string"),
 *     @SWG\Property(property="rendering_provider_npi_3", type="string"),
 *     @SWG\Property(property="rendering_provider_entity_4", type="string"),
 *     @SWG\Property(property="rendering_provider_first_name_4", type="string"),
 *     @SWG\Property(property="rendering_provider_last_name_4", type="string"),
 *     @SWG\Property(property="rendering_provider_org_4", type="string"),
 *     @SWG\Property(property="rendering_provider_npi_4", type="string"),
 *     @SWG\Property(property="rendering_provider_entity_5", type="string"),
 *     @SWG\Property(property="rendering_provider_first_name_5", type="string"),
 *     @SWG\Property(property="rendering_provider_last_name_5", type="string"),
 *     @SWG\Property(property="rendering_provider_org_5", type="string"),
 *     @SWG\Property(property="rendering_provider_npi_5", type="string"),
 *     @SWG\Property(property="rendering_provider_entity_6", type="string"),
 *     @SWG\Property(property="rendering_provider_first_name_6", type="string"),
 *     @SWG\Property(property="rendering_provider_last_name_6", type="string"),
 *     @SWG\Property(property="rendering_provider_org_6", type="string"),
 *     @SWG\Property(property="rendering_provider_npi_6", type="string"),
 *     @SWG\Property(property="payer_id", type="string"),
 *     @SWG\Property(property="payer_name", type="string"),
 *     @SWG\Property(property="payer_address", type="string"),
 *     @SWG\Property(property="payer_city", type="string"),
 *     @SWG\Property(property="payer_state", type="string"),
 *     @SWG\Property(property="payer_zip", type="string"),
 *     @SWG\Property(property="billing_provider_taxonomy_code", type="string"),
 *     @SWG\Property(property="other_insured_insurance_type", type="string"),
 *     @SWG\Property(property="claim_info_code", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\InsuranceHistory
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
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAcceptAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAnotherPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAutoAccident($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAutoAccidentPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBalanceDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderBOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderDd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderPhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderTaxonomyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBoPaidViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereClaimCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereClaimInfoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereClosedByOfficeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCurrentQual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDateCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDateSameIllness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDisputeReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEligibleResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEligibleToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmployment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereFederalTaxIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereField17a($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereField17aDd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereField17b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereFoPaidViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereHospitalizationDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereHospitalizationDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIcdInd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuranceid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredMiddle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredPhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereMailedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereMedicaidResubmissionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier13($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier14($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier22($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier23($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier24($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier31($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier32($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier33($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier34($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier41($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier42($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier43($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier44($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier51($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier52($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier53($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier54($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier61($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier62($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier63($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier64($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNameReferringProviderQualifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc10d($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc30($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc8a($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc8b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc9a($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc9b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc9c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOriginalRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherAccident($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredMiddle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOutsideLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMDssFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMEligiblePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMEligiblePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientMiddle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientPhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientRelationInsured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientRelationOtherInsured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientSignedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePhysicianSignedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePica1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePica2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePica3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePrimaryClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePrimaryClaimVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePrimaryFdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePriorAuthorizationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereReferringProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereReservedLocalUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereReservedLocalUse1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereResponsibilitySequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereResubmissionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereResubmissionCodeFill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges22($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges31($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges32($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges41($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges42($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges51($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges52($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges61($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges62($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMDssFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMEligiblePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMEligiblePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSameIllnessQual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecDisputeReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecMailedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecondaryClaimVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecondaryFdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate1From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate1To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate2From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate2To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate3From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate3To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate4From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate4To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate5From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate5To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate6From($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate6To($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceFacilityInfoAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceFacilityInfoCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceFacilityInfoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceInfoA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceInfoBOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceInfoDd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSignaturePhysician($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereTotalCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUnableDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUnableDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUpdatedByAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUpdatedByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUserid($value)
 * @mixin \Eloquent
 */
class InsuranceHistory extends AbstractModel implements Resource, Repository
{
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
    protected $table = 'dental_insurance_history';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['mailed_date', 'sec_mailed_date', 'percase_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}

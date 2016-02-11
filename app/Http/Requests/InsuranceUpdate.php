<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'                            => 'integer',
            'patientid'                         => 'sometimes|required|integer',
            'pica1'                             => 'string',
            'pica2'                             => 'string',
            'pica3'                             => 'string',
            'insurance_type'                    => 'string',
            'insured_id_number'                 => 'string',
            'patient_firstname'                 => 'sometimes|required|string',
            'patient_lastname'                  => 'sometimes|required|string',
            'patient_middle'                    => 'string',
            'patient_dob'                       => 'string',
            'patient_sex'                       => 'string',
            'insured_firstname'                 => 'string',
            'insured_lastname'                  => 'string',
            'insured_middle'                    => 'string',
            'patient_address'                   => 'sometimes|required|string',
            'patient_relation_insured'          => 'string',
            'insured_address'                   => 'string',
            'patient_city'                      => 'string',
            'patient_state'                     => 'string',
            'patient_status'                    => 'regex:/^~[A-Za-z]+~$/',
            'insured_city'                      => 'string',
            'insured_state'                     => 'string',
            'patient_zip'                       => 'regex:/^[0-9]{5}$/',
            'patient_phone_code'                => 'regex:/^[0-9]{3}$/',
            'patient_phone'                     => 'string',
            'insured_zip'                       => 'regex:/^[0-9]{5}$/',
            'insured_phone_code'                => 'regex:/^[0-9]{3}$/',
            'insured_phone'                     => 'string',
            // 'other_insured_firstname'
            // 'other_insured_lastname'
            // 'other_insured_middle'
            // 'employment'
            // 'auto_accident'
            // 'auto_accident_place'
            // 'other_accident'
            'insured_policy_group_feca'         => 'string',
            // 'other_insured_policy_group_feca'
            'insured_dob'                       => 'string',
            'insured_sex'                       => 'string',
            // 'other_insured_dob'
            // 'other_insured_sex'
            'insured_employer_school_name'      => 'string',
            // 'other_insured_employer_school_name'
            'insured_insurance_plan'            => 'string',
            'other_insured_insurance_plan'      => 'string',
            // 'reserved_local_use'
            'another_plan'                      => 'regex:/^(?:NO|YES)$/',
            'patient_signature'                 => 'string',
            'patient_signed_date'               => 'string',
            'insured_signature'                 => 'string',
            // 'date_current'
            // 'date_same_illness'
            // 'unable_date_from'
            // 'unable_date_to'
            // 'referring_provider'
            // 'field_17a_dd'
            // 'field_17a'
            // 'field_17b'
            // 'hospitalization_date_from'
            // 'hospitalization_date_to'
            // 'reserved_local_use1'
            // 'outside_lab'
            // 's_charges'
            'diagnosis_1'                       => 'string',
            'diagnosis_2'                       => 'string',
            'diagnosis_3'                       => 'string',
            'diagnosis_4'                       => 'string',
            // 'medicaid_resubmission_code'
            // 'original_ref_no'
            // 'prior_authorization_number'
            'service_date1_from'                => 'string',
            'service_date1_to'                  => 'string',
            'place_of_service1'                 => 'string',
            // 'emg1'
            'cpt_hcpcs1'                        => 'regex:/^[A-Z][0-9]{4}$/',
            // 'modifier1_1'
            // 'modifier1_2'
            // 'modifier1_3'
            // 'modifier1_4'
            // 'diagnosis_pointer1'
            's_charges1_1'                      => 'string',
            's_charges1_2'                      => 'string',
            // 'days_or_units1'
            // 'epsdt_family_plan1'
            // 'id_qua1'
            // 'rendering_provider_id1'
            // 'service_date2_from'
            // 'service_date2_to'
            // 'place_of_service2'
            // 'emg2'
            // 'cpt_hcpcs2'
            // 'modifier2_1'
            // 'modifier2_2'
            // 'modifier2_3'
            // 'modifier2_4'
            // 'diagnosis_pointer2'
            // 's_charges2_1'
            // 's_charges2_2'
            // 'days_or_units2'
            // 'epsdt_family_plan2'
            // 'id_qua2'
            // 'rendering_provider_id2'
            // 'service_date3_from'
            // 'service_date3_to'
            // 'place_of_service3'
            // 'emg3'
            // 'cpt_hcpcs3'
            // 'modifier3_1'
            // 'modifier3_2'
            // 'modifier3_3'
            // 'modifier3_4'
            // 'diagnosis_pointer3'
            // 's_charges3_1'
            // 's_charges3_2'
            // 'days_or_units3'
            // 'epsdt_family_plan3'
            // 'id_qua3'
            // 'rendering_provider_id3'
            // 'service_date4_from'
            // 'service_date4_to'
            // 'place_of_service4'
            // 'emg4'
            // 'cpt_hcpcs4'
            // 'modifier4_1'
            // 'modifier4_2'
            // 'modifier4_3'
            // 'modifier4_4'
            // 'diagnosis_pointer4'
            // 's_charges4_1'
            // 's_charges4_2'
            // 'days_or_units4'
            // 'epsdt_family_plan4'
            // 'id_qua4'
            // 'rendering_provider_id4'
            // 'service_date5_from'
            // 'service_date5_to'
            // 'place_of_service5'
            // 'emg5'
            // 'cpt_hcpcs5'
            // 'modifier5_1'
            // 'modifier5_2'
            // 'modifier5_3'
            // 'modifier5_4'
            // 'diagnosis_pointer5'
            // 's_charges5_1'
            // 's_charges5_2'
            // 'days_or_units5'
            // 'epsdt_family_plan5'
            // 'id_qua5'
            // 'rendering_provider_id5'
            // 'service_date6_from'
            // 'service_date6_to'
            // 'place_of_service6'
            // 'emg6'
            // 'cpt_hcpcs6'
            // 'modifier6_1'
            // 'modifier6_2'
            // 'modifier6_3'
            // 'modifier6_4'
            // 'diagnosis_pointer6'
            // 's_charges6_1'
            // 's_charges6_2'
            // 'days_or_units6'
            // 'epsdt_family_plan6'
            // 'id_qua6'
            // 'rendering_provider_id6'
            'federal_tax_id_number'             => 'string',
            // 'ssn'
            'ein'                               => 'string',
            // 'patient_account_no'
            'accept_assignment'                 => 'regex:/^(?:Yes|No|A|C)$/',
            'total_charge'                      => 'regex:/^(?:[1-9]+[0-9]*\,)?[0-9]+\.[0-9]{2}$/',
            'amount_paid'                       => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'balance_due'                       => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'signature_physician'               => 'string',
            'physician_signed_date'             => 'string',
            'service_facility_info_name'        => 'string',
            'service_facility_info_address'     => 'string',
            'service_facility_info_city'        => 'string',
            'service_info_a'                    => 'string',
            // 'service_info_dd'
            // 'service_info_b_other'
            'billing_provider_phone_code'       => 'regex:/[0-9]{3}/',
            'billing_provider_phone'            => 'string',
            'billing_provider_name'             => 'string',
            'billing_provider_address'          => 'string',
            'billing_provider_city'             => 'string',
            'billing_provider_a'                => 'string',
            // 'billing_provider_dd'
            // 'billing_provider_b_other'
            'userid'                            => 'sometimes|required|integer',
            'docid'                             => 'sometimes|required|integer',
            'status'                            => 'integer',
            'card'                              => 'integer',
            'dispute_reason'                    => 'string',
            // 'sec_dispute_reason'
            // 'reject_reason'
            'primary_fdf'                       => 'regex:/^fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf$/',
            'secondary_fdf'                     => 'regex:/^fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf$/',
            'producer'                          => 'integer',
            'mailed_date'                       => 'date',
            'eligible_response'                 => 'string',
            'p_m_eligible_payer_id'             => 'string',
            'p_m_eligible_payer_name'           => 'string',
            // 'sec_mailed_date'
            // 'other_insurance_type'
            // 'patient_relation_other_insured'
            // 'p_m_billing_id'
            // 'p_m_dss_file'
            // 's_m_billing_id'
            // 's_m_dss_file'
            // 'other_insured_address'
            // 'other_insured_city'
            // 'other_insured_state'
            // 'other_insured_zip'
            'eligible_token'                    => 'string',
            'percase_date'                      => 'date',
            'percase_name'                      => 'string',
            'percase_amount'                    => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'percase_status'                    => 'integer',
            'percase_invoice'                   => 'integer',
            'primary_claim_id'                  => 'integer',
            'fo_paid_viewed'                    => 'integer',
            'bo_paid_viewed'                    => 'integer',
            // 'closed_by_office_type'
            // 's_m_eligible_payer_id'
            // 's_m_eligible_payer_name'
            // 'other_insured_id_number'
            'primary_claim_version'             => 'integer',
            'secondary_claim_version'           => 'integer',
            // 'nucc_8a'
            // 'nucc_8b'
            // 'nucc_9a'
            // 'nucc_9b'
            // 'nucc_9c'
            // 'nucc_10d'
            // 'nucc_30'
            // 'claim_codes'
            // 'other_claim_id'
            'icd_ind'                           => 'integer',
            'name_referring_provider_qualifier' => 'string'
            // 'diagnosis_a'
            // 'diagnosis_b'
            // 'diagnosis_c'
            // 'diagnosis_d'
            // 'diagnosis_e'
            // 'diagnosis_f'
            // 'diagnosis_g'
            // 'diagnosis_h'
            // 'diagnosis_i'
            // 'diagnosis_j'
            // 'diagnosis_k'
            // 'diagnosis_l'
            // 'current_qual'
            // 'same_illness_qual'
            // 'resubmission_code'
            // 'resubmission_code_fill'
            // 'responsibility_sequence'
            // 'rendering_provider_entity_1'
            // 'rendering_provider_first_name_1'
            // 'rendering_provider_last_name_1'
            // 'rendering_provider_org_1'
            // 'rendering_provider_npi_1'
            // 'rendering_provider_entity_2'
            // 'rendering_provider_first_name_2'
            // 'rendering_provider_last_name_2'
            // 'rendering_provider_org_2'
            // 'rendering_provider_npi_2'
            // 'rendering_provider_entity_3'
            // 'rendering_provider_first_name_3'
            // 'rendering_provider_last_name_3'
            // 'rendering_provider_org_3'
            // 'rendering_provider_npi_3'
            // 'rendering_provider_entity_4'
            // 'rendering_provider_first_name_4'
            // 'rendering_provider_last_name_4'
            // 'rendering_provider_org_4'
            // 'rendering_provider_npi_4'
            // 'rendering_provider_entity_5'
            // 'rendering_provider_first_name_5'
            // 'rendering_provider_last_name_5'
            // 'rendering_provider_org_5'
            // 'rendering_provider_npi_5'
            // 'rendering_provider_entity_6'
            // 'rendering_provider_first_name_6'
            // 'rendering_provider_last_name_6'
            // 'rendering_provider_org_6'
            // 'rendering_provider_npi_6'
        ];
    }
}

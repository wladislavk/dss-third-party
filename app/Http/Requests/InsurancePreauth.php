<?php

namespace DentalSleepSolutions\Http\Requests;

class InsurancePreauth extends Request
{
    protected $rules = [
        'doc_id'                            => 'required|integer',
        'patient_id'                        => 'required|integer',
        'ins_co'                            => 'string',
        'ins_rank'                          => 'string',
        'ins_phone'                         => 'regex:/^[0-9]{10}$/',
        'patient_ins_group_id'              => 'string',
        'patient_ins_id'                    => 'string',
        'patient_firstname'                 => 'required|string',
        'patient_lastname'                  => 'required|string',
        'patient_add1'                      => 'string',
        'patient_add2'                      => 'string',
        'patient_city'                      => 'string',
        'patient_state'                     => 'string',
        'patient_zip'                       => 'string',
        'patient_dob'                       => 'date',
        'insured_first_name'                => 'string',
        'insured_last_name'                 => 'string',
        'insured_dob'                       => 'date',
        'doc_npi'                           => 'string',
        'referring_doc_npi'                 => 'string',
        'trxn_code_amount'                  => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'diagnosis_code'                    => 'string',
        'date_of_call'                      => 'date',
        'insurance_rep'                     => 'string',
        'call_reference_num'                => 'string',
        'doc_medicare_npi'                  => 'string',
        'doc_tax_id_or_ssn'                 => 'string',
        'ins_effective_date'                => 'date',
        'ins_cal_year_start'                => 'date',
        'ins_cal_year_end'                  => 'date',
        'trxn_code_covered'                 => 'integer',
        'code_covered_notes'                => 'string',
        'has_out_of_network_benefits'       => 'integer',
        'out_of_network_percentage'         => 'integer',
        'is_hmo'                            => 'integer',
        'hmo_date_called'                   => 'date',
        'hmo_date_received'                 => 'date',
        'hmo_needs_auth'                    => 'integer',
        'hmo_auth_date_requested'           => 'date',
        'hmo_auth_date_received'            => 'date',
        'hmo_auth_notes'                    => 'string',
        'in_network_percentage'             => 'integer',
        'in_network_appeal_date_sent'       => 'date',
        'in_network_appeal_date_received'   => 'date',
        'is_pre_auth_required'              => 'integer',
        'verbal_pre_auth_name'              => 'string',
        'verbal_pre_auth_ref_num'           => 'string',
        'verbal_pre_auth_notes'             => 'string',
        'written_pre_auth_notes'            => 'string',
        'written_pre_auth_date_received'    => 'date',
        'front_office_request_date'         => 'date',
        'status'                            => 'integer',
        'patient_deductible'                => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'patient_amount_met'                => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'family_deductible'                 => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'family_amount_met'                 => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'deductible_reset_date'             => 'date',
        'out_of_pocket_met'                 => 'integer',
        'patient_amount_left_to_meet'       => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'expected_insurance_payment'        => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'expected_patient_payment'          => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'network_benefits'                  => 'integer',
        'viewed'                            => 'integer',
        'date_completed'                    => 'date',
        'userid'                            => 'required|integer',
        'how_often'                         => 'string',
        'patient_phone'                     => 'regex:/[0-9]{10}/',
        'pre_auth_num'                      => 'string',
        'family_amount_left_to_meet'        => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'deductible_from'                   => 'integer',
        'reject_reason'                     => 'string',
        'invoice_date'                      => 'date',
        'invoice_amount'                    => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'invoice_status'                    => 'integer',
        'invoice_id'                        => 'integer',
        'updated_by'                        => 'integer',
        'doc_name'                          => 'string',
        'doc_practice'                      => 'string',
        'doc_address'                       => 'string',
        'doc_phone'                         => 'regex:/[0-9]{10}/',
        'in_deductible_from'                => 'integer',
        'in_patient_deductible'             => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_patient_amount_met'             => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_patient_amount_left_to_meet'    => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_family_deductible'              => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_family_amount_met'              => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_family_amount_left_to_meet'     => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_deductible_reset_date'          => 'date',
        'in_out_of_pocket_met'              => 'integer',
        'in_expected_insurance_payment'     => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_expected_patient_payment'       => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'in_call_reference_num'             => 'string',
        'has_in_network_benefits'           => 'integer',
        'in_is_pre_auth_required'           => 'integer',
        'in_verbal_pre_auth_name'           => 'string',
        'in_verbal_pre_auth_ref_num'        => 'string',
        'in_verbal_pre_auth_notes'          => 'string',
        'in_written_pre_auth_date_received' => 'date',
        'in_pre_auth_num'                   => 'string',
        'in_written_pre_auth_notes'         => 'string',
    ];
}

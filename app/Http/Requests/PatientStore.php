<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lastname'                => 'required|string',
            'firstname'               => 'required|string',
            'middlename'              => 'string',
            'salutation'              => 'string',
            'member_no'               => 'string',
            'group_no'                => 'string',
            'plan_no'                 => 'string',
            'dob'                     => 'required|string',
            'add1'                    => 'string',
            'add2'                    => 'string',
            'city'                    => 'string',
            'state'                   => 'string',
            'zip'                     => 'regex:/[0-9]{5}/',
            'gender'                  => ['required', 'regex:/^(?:Male|Female)$/'],
            'marital_status'          => ['regex:/^(?:Married|Un-Married|Single)$/'],
            'ssn'                     => 'required|string',
            'internal_patient'        => 'string',
            'home_phone'              => 'required|regex:/^[0-9]{10}$/',
            'work_phone'              => 'required|regex:/^[0-9]{10}$/',
            'cell_phone'              => 'required|regex:/^[0-9]{10}$/',
            'email'                   => 'required|email',
            'patient_notes'           => 'string',
            'alert_text'              => 'string',
            'display_alert'           => 'integer',
            'userid'                  => 'integer',
            'docid'                   => 'integer',
            'status'                  => 'integer',
            'p_d_party'               => 'string',
            'p_d_relation'            => 'string',
            'p_d_other'               => 'string',
            'p_d_employer'            => 'string',
            'p_d_ins_co'              => 'string',
            'p_d_ins_id'              => 'string',
            's_d_party'               => 'string',
            's_d_relation'            => 'string',
            's_d_other'               => 'string',
            's_d_employer'            => 'string',
            's_d_ins_co'              => 'string',
            's_d_ins_id'              => 'string',
            'p_m_partyfname'          => 'string',
            'p_m_partymname'          => 'string',
            'p_m_partylname'          => 'string',
            'p_m_relation'            => 'string',
            'p_m_other'               => 'string',
            'p_m_employer'            => 'string',
            'p_m_ins_co'              => 'string',
            'p_m_ins_id'              => 'string',
            's_m_partyfname'          => 'string',
            's_m_partymname'          => 'string',
            's_m_partylname'          => 'string',
            's_m_relation'            => 'string',
            's_m_other'               => 'string',
            's_m_employer'            => 'string',
            's_m_ins_co'              => 'string',
            's_m_ins_id'              => 'string',
            'p_m_ins_grp'             => 'string',
            's_m_ins_grp'             => 'string',
            'p_m_ins_plan'            => 'string',
            's_m_ins_plan'            => 'string',
            'p_m_dss_file'            => 'string',
            's_m_dss_file'            => 'string',
            'p_m_ins_type'            => 'string',
            's_m_ins_type'            => 'string',
            'p_m_ins_ass'             => 'string',
            's_m_ins_ass'             => 'string',
            'ins_dob'                 => 'date',
            'ins2_dob'                => 'date',
            'employer'                => 'string',
            'emp_add1'                => 'string',
            'emp_add2'                => 'string',
            'emp_city'                => 'string',
            'emp_state'               => 'string',
            'emp_zip'                 => 'regex:/^[0-9]{5}$/',
            'emp_phone'               => 'string',
            'emp_fax'                 => 'string',
            'plan_name'               => 'string',
            'group_number'            => 'string',
            'ins_type'                => 'string',
            'accept_assignment'       => 'string',
            'print_signature'         => 'string',
            'medical_insurance'       => 'string',
            'mark_yes'                => 'string',
            'inactive'                => 'string',
            'partner_name'            => 'string',
            'emergency_name'          => 'string',
            'emergency_number'        => 'string',
            'referred_source'         => 'integer',
            'referred_by'             => 'integer',
            'premedcheck'             => 'integer',
            'premed'                  => 'string',
            'docsleep'                => 'string',
            'docpcp'                  => 'string',
            'docdentist'              => 'string',
            'docent'                  => 'string',
            'docmdother'              => 'string',
            'preferredcontact'        => ['regex:/^(?:email|paper)$/'],
            'copyreqdate'             => 'string',
            'best_time'               => ['regex:/^(?:morning|midday|evening)$/'],
            'best_number'             => ['regex:/^(?:home|work)$/'],
            'emergency_relationship'  => 'string',
            'has_s_m_ins'             => ['regex:/^(?:No|Yes)$/'],
            'referred_notes'          => 'string',
            'login'                   => 'string',
            'password'                => 'string',
            'salt'                    => 'string',
            'recover_hash'            => 'string',
            'recover_time'            => 'date',
            'registered'              => 'integer',
            'access_code'             => 'string',
            'parent_patientid'        => 'integer',
            'has_p_m_ins'             => 'string',
            'registration_status'     => 'integer',
            'text_date'               => 'date',
            'text_num'                => 'integer',
            'use_patient_portal'      => 'integer',
            'registration_senton'     => 'date',
            'preferred_name'          => 'string',
            'feet'                    => 'string',
            'inches'                  => 'string',
            'weight'                  => 'string',
            'bmi'                     => 'string',
            'symptoms_status'         => 'integer',
            'sleep_status'            => 'integer',
            'treatments_status'       => 'integer',
            'history_status'          => 'integer',
            'access_code_date'        => 'date',
            'email_bounce'            => 'integer',
            'docmdother2'             => 'string',
            'docmdother3'             => 'string',
            'last_reg_sect'           => 'integer',
            'access_type'             => 'integer',
            'p_m_eligible_id'         => 'string',
            'p_m_eligible_payer_id'   => 'string',
            'p_m_eligible_payer_name' => 'string',
            'p_m_gender'              => 'string',
            's_m_gender'              => 'string',
            'p_m_same_address'        => 'integer',
            'p_m_address'             => 'string',
            'p_m_state'               => 'string',
            'p_m_city'                => 'string',
            'p_m_zip'                 => 'regex:/^[0-9]{5}$/',
            's_m_same_address'        => 'string',
            's_m_address'             => 'string',
            's_m_city'                => 'string',
            's_m_state'               => 'string',
            's_m_zip'                 => 'regex:/^[0-9]{5}$/',
            'new_fee_date'            => 'date',
            'new_fee_amount'          => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'new_fee_desc'            => 'string',
            'new_fee_invoice_id'      => 'integer',
            's_m_eligible_payer_id'   => 'string',
            's_m_eligible_payer_name' => 'string'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class HomeSleepTestStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doc_id'               => 'required|integer',
            'user_id'              => 'required|integer',
            'company_id'           => 'integer',
            'patient_id'           => 'required|integer',
            'screener_id'          => 'integer',
            'ins_co_id'            => 'integer',
            'ins_phone'            => 'regex:/^[0-9]{10}$/',
            'patient_ins_group_id' => 'string',
            'patient_ins_id'       => 'string',
            'patient_firstname'    => 'required|string',
            'patient_lastname'     => 'required|string',
            'patient_add1'         => 'string',
            'patient_add2'         => 'string',
            'patient_city'         => 'string',
            'patient_state'        => 'string',
            'patient_zip'          => 'regex:/^[0-9]{5}$/',
            'patient_dob'          => 'string',
            'patient_cell_phone'   => 'regex:/^[0-9]{10}$/',
            'patient_home_phone'   => 'regex:/^[0-9]{10}$/',
            'patient_email'        => 'email',
            'diagnosis_id'         => 'integer',
            'hst_type'             => 'integer',
            'provider_firstname'   => 'required|string',
            'provider_lastname'    => 'required|string',
            'provider_phone'       => 'regex:/^[0-9]{10}$/',
            'provider_address'     => 'string',
            'provider_city'        => 'string',
            'provider_state'       => 'string',
            'provider_zip'         => 'regex:/^[0-9]{5}$/',
            'provider_signature'   => 'string',
            'provider_date'        => 'string',
            'snore_1'              => 'integer',
            'snore_2'              => 'integer',
            'snore_3'              => 'integer',
            'snore_4'              => 'integer',
            'snore_5'              => 'integer',
            'viewed'               => 'integer',
            'status'               => 'integer',
            'office_notes'         => 'string',
            'sleep_study_id'       => 'integer',
            'authorized_id'        => 'integer',
            'authorizeddate'       => 'date',
            'updatedate'           => 'date',
            'rejected_reason'      => 'string',
            'rejecteddate'         => 'date',
            'canceled_id'          => 'integer',
            'canceled_date'        => 'date',
            'hst_nights'           => 'integer',
            'hst_positions'        => 'string'
        ];
    }
}

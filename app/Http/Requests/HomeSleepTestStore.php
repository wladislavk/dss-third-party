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
            'ins_phone'            => 'required|string',
            'patient_ins_group_id' => 'string',
            'patient_ins_id'       => 'required|string',
            'patient_firstname'    => 'required|string',
            'patient_lastname'     => 'required|string',
            'patient_add1'         => 'required|string',
            'patient_add2'         => 'required|string',
            'patient_city'         => 'required|string',
            'patient_state'        => 'required|string',
            'patient_zip'          => 'required|string',
            'patient_dob'          => 'string',
            'patient_cell_phone'   => 'string',
            'patient_home_phone'   => 'string',
            'patient_email'        => 'required|email',
            'diagnosis_id'         => 'integer',
            'hst_type'             => 'integer',
            'provider_firstname'   => 'required|string',
            'provider_lastname'    => 'required|string',
            'provider_phone'       => 'required|string',
            'provider_address'     => 'required|string',
            'provider_city'        => 'required|string',
            'provider_state'       => 'required|string',
            'provider_zip'         => 'required|string',
            'provider_signature'   => 'required|string',
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

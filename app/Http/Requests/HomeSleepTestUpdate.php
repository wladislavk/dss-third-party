<?php

namespace DentalSleepSolutions\Http\Requests;

class HomeSleepTestUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doc_id'               => 'sometimes|required|integer',
            'user_id'              => 'sometimes|required|integer',
            'company_id'           => 'integer',
            'patient_id'           => 'sometimes|required|integer',
            'screener_id'          => 'integer',
            'ins_co_id'            => 'integer',
            'ins_phone'            => 'sometimes|required|string',
            'patient_ins_group_id' => 'string',
            'patient_ins_id'       => 'sometimes|required|string',
            'patient_firstname'    => 'sometimes|required|string',
            'patient_lastname'     => 'sometimes|required|string',
            'patient_add1'         => 'sometimes|required|string',
            'patient_add2'         => 'sometimes|required|string',
            'patient_city'         => 'sometimes|required|string',
            'patient_state'        => 'sometimes|required|string',
            'patient_zip'          => 'sometimes|required|string',
            'patient_dob'          => 'string',
            'patient_cell_phone'   => 'string',
            'patient_home_phone'   => 'string',
            'patient_email'        => 'sometimes|required|email',
            'diagnosis_id'         => 'integer',
            'hst_type'             => 'integer',
            'provider_firstname'   => 'sometimes|required|string',
            'provider_lastname'    => 'sometimes|required|string',
            'provider_phone'       => 'sometimes|required|string',
            'provider_address'     => 'sometimes|required|string',
            'provider_city'        => 'sometimes|required|string',
            'provider_state'       => 'sometimes|required|string',
            'provider_zip'         => 'sometimes|required|string',
            'provider_signature'   => 'sometimes|required|string',
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

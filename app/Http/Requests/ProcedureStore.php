<?php

namespace DentalSleepSolutions\Http\Requests;

class ProcedureStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'          => 'required|integer',
            'insuranceid'        => 'required|integer',
            'service_date_from'  => 'date',
            'service_date_to'    => 'date',
            'place_service'      => 'regex:/^[0-9]+$/',
            'type_service'       => 'regex:/^[0-9]+$/',
            'cpt_code'           => 'regex:/^[0-9]+$/',
            'units'              => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'charge'             => 'required|regex:/^[0-9]+\.[0-9]{1,2}$/',
            'total_charge'       => 'required|regex:/^[0-9]+\.[0-9]{1,2}$/',
            'applies_icd'        => 'regex:/^[0-9]+\,[0-9]{1,2}$/',
            'npi'                => 'string',
            'other_id'           => 'regex:/^[0-9]+$/',
            'other_id_qualifier' => 'regex:/^[0-9]+$/',
            'modifier_code_1'    => 'regex:/^[0-9]+$/',
            'modifier_code_2'    => 'regex:/^[0-9]+$/',
            'modifier_code_3'    => 'regex:/^[0-9]+$/',
            'modifier_code_4'    => 'regex:/^[0-9]+$/',
            'epsdt'              => 'regex:/^[0-9]+$/',
            'emg'                => 'string',
            'supplemental_info'  => 'string',
            'docid'              => 'required|integer',
            'status'             => 'integer'
        ];
    }
}

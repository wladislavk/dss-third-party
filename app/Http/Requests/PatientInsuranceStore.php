<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientInsuranceStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'     => 'required|integer',
            'insurancetype' => 'integer',
            'company'       => 'required|string',
            'address1'      => 'string',
            'address2'      => 'string',
            'city'          => 'string',
            'state'         => 'string',
            'zip'           => 'regex:/[0-9]{5}/',
            'phone'         => 'regex:/[0-9]{10}/',
            'fax'           => 'string',
            'email'         => 'email'
        ];
    }
}

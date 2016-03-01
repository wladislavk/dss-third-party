<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientContactStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contacttype' => 'required|integer',
            'patientid'   => 'required|integer',
            'firstname'   => 'required|string',
            'lastname'    => 'required|string',
            'address1'    => 'string',
            'address2'    => 'string',
            'city'        => 'string',
            'state'       => 'string',
            'zip'         => 'regex:/^[0-9]{5}$/',
            'phone'       => 'regex:/^[0-9]{10}$/'
        ];
    }
}

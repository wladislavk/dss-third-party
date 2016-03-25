<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientContactUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contacttype' => 'sometimes|required|integer',
            'patientid'   => 'sometimes|required|integer',
            'firstname'   => 'sometimes|required|string',
            'lastname'    => 'sometimes|required|string',
            'address1'    => 'string',
            'address2'    => 'string',
            'city'        => 'string',
            'state'       => 'string',
            'zip'         => 'regex:/^[0-9]{5}$/',
            'phone'       => 'regex:/^[0-9]{10}$/'
        ];
    }
}

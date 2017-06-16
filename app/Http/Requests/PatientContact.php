<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientContact extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
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

    public function updateRules()
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

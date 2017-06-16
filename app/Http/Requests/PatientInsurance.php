<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientInsurance extends Request
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

    public function updateRules()
    {
        return [
            'patientid'     => 'sometimes|required|integer',
            'insurancetype' => 'integer',
            'company'       => 'sometimes|required|string',
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

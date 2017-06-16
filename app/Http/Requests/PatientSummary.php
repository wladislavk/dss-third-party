<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientSummary extends Request
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
            'pid'              => 'required|integer',
            'fspage1_complete' => 'boolean',
            'next_visit'       => 'date',
            'last_visit'       => 'date',
            'last_treatment'   => 'string',
            'appliance'        => 'integer',
            'delivery_date'    => 'date',
            'vob'              => 'string',
            'ledger'           => 'regex:/^-?[0-9]+\.[0-9]{2}$/',
            'patient_info'     => 'boolean'
        ];
    }

    public function updateRules()
    {
        return [
            'pid'              => 'sometimes|required|integer',
            'fspage1_complete' => 'boolean',
            'next_visit'       => 'date',
            'last_visit'       => 'date',
            'last_treatment'   => 'string',
            'appliance'        => 'integer',
            'delivery_date'    => 'date',
            'vob'              => 'string',
            'ledger'           => 'regex:/^-?[0-9]+\.[0-9]{2}$/',
            'patient_info'     => 'boolean'
        ];
    }
}

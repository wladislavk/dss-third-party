<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientSummaryUpdate extends AbstractUpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimElectronicUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claimid'         => 'sometimes|required|integer',
            'response'        => 'sometimes|required|string',
            'reference_id'    => 'string',
            'percase_date'    => 'date',
            'percase_name'    => 'string',
            'percase_amount'  => 'regex:/^\d*(\.\d{2})?$/',
            'percase_status'  => 'integer',
            'percase_invoice' => 'integer',
            'percase_free'    => 'integer',
        ];
    }
}
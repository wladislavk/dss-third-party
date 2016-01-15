<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimElectronicStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claimid'         => 'required|integer',
            'response'        => 'required|string',
            'reference_id'    => 'string',
            'percase_date'    => 'date',
            'percase_name'    => 'string',
            'percase_amount'  => 'integer',
            'percase_status'  => 'integer',
            'percase_invoice' => 'integer',
            'percase_free'    => 'integer',
        ];
    }
}

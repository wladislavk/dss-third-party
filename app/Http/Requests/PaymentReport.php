<?php

namespace DentalSleepSolutions\Http\Requests;

class PaymentReport extends Request
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
            'claimid'      => 'required|integer',
            'reference_id' => 'required|string',
            'response'     => 'json',
            'viewed'       => 'boolean'
        ];
    }

    public function updateRules()
    {
        return [
            'claimid'      => 'sometimes|required|integer',
            'reference_id' => 'sometimes|required|string',
            'response'     => 'json',
            'viewed'       => 'boolean'
        ];
    }
}

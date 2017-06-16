<?php

namespace DentalSleepSolutions\Http\Requests;

class Refund extends Request
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
            'amount'      => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'userid'      => 'required|integer',
            'adminid'     => 'required|integer',
            'refund_date' => 'date',
            'charge_id'   => 'required|integer'
        ];
    }

    public function updateRules()
    {
        return [
            'amount'      => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'userid'      => 'sometimes|required|integer',
            'adminid'     => 'sometimes|required|integer',
            'refund_date' => 'date',
            'charge_id'   => 'sometimes|required|integer'
        ];
    }
}

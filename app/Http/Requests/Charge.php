<?php

namespace DentalSleepSolutions\Http\Requests;

class Charge extends Request
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
            'amount'                  => 'required|regex:/^\d*(\.\d{2})?$/',
            'userid'                  => 'required|integer',
            'adminid'                 => 'required|integer',
            'charge_date'             => 'required|date',
            'stripe_customer'         => 'string',
            'stripe_charge'           => 'string',
            'stripe_card_fingerprint' => 'string',
            'invoice_id'              => 'integer',
            'status'                  => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'amount'                  => 'sometimes|required|regex:/^\d*(\.\d{2})?$/',
            'userid'                  => 'sometimes|required|integer',
            'adminid'                 => 'sometimes|required|integer',
            'charge_date'             => 'sometimes|required|date',
            'stripe_customer'         => 'string',
            'stripe_charge'           => 'string',
            'stripe_card_fingerprint' => 'string',
            'invoice_id'              => 'integer',
            'status'                  => 'integer'
        ];
    }
}

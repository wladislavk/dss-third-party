<?php

namespace DentalSleepSolutions\Http\Requests;

class Charge extends Request
{
    protected $rules = [
        'amount'                  => 'required|regex:/^\d*(\.\d{2})?$/',
        'userid'                  => 'required|integer',
        'adminid'                 => 'required|integer',
        'charge_date'             => 'required|date',
        'stripe_customer'         => 'string',
        'stripe_charge'           => 'string',
        'stripe_card_fingerprint' => 'string',
        'invoice_id'              => 'integer',
        'status'                  => 'integer',
    ];
}

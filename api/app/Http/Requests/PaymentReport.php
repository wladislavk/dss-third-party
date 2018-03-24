<?php

namespace DentalSleepSolutions\Http\Requests;

class PaymentReport extends Request
{
    protected $rules = [
        'claimid'      => 'required|integer',
        'reference_id' => 'required|string',
        'response'     => 'json',
        'viewed'       => 'boolean',
    ];
}

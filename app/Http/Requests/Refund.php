<?php

namespace DentalSleepSolutions\Http\Requests;

class Refund extends Request
{
    protected $rules = [
        'amount'      => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
        'userid'      => 'required|integer',
        'adminid'     => 'required|integer',
        'refund_date' => 'date',
        'charge_id'   => 'required|integer',
    ];
}

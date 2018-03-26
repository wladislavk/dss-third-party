<?php

namespace DentalSleepSolutions\Http\Requests;

class TransactionCode extends Request
{
    protected $rules = [
        'transaction_code' => 'required|string',
        'description'      => 'required|string',
        'type'             => 'required|regex:/^[0-9]$/',
        'sortby'           => 'integer',
        'status'           => 'integer',
        'default_code'     => 'integer',
        'docid'            => 'required|integer',
        'amount'           => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'place'            => 'integer',
        'modifier_code_1'  => 'string',
        'modifier_code_2'  => 'string',
        'days_units'       => 'regex:/^[0-9]$/',
        'amount_adjust'    => 'integer',
    ];
}

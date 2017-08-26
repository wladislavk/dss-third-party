<?php

namespace DentalSleepSolutions\Http\Requests;

class PercaseInvoice extends Request
{
    protected $rules = [
        'adminid'             => 'required|integer',
        'docid'               => 'required|integer',
        'monthly_fee_date'    => 'date',
        'monthly_fee_amount'  => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
        'status'              => 'integer',
        'due_date'            => 'date',
        'companyid'           => 'integer',
        'user_fee_date'       => 'date',
        'user_fee_amount'     => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
        'producer_fee_date'   => 'date',
        'producer_fee_amount' => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
        'user_fee_desc'       => 'string',
        'producer_fee_desc'   => 'string',
        'invoice_type'        => 'integer',
    ];
}

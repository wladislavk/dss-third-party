<?php

namespace DentalSleepSolutions\Http\Requests;

class FaxInvoice extends Request
{
    protected $rules = [
        'invoice_id'  => 'required|integer',
        'description' => 'string',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date',
        'amount'      => 'regex:/^\d*(\.\d{2})?$/'
    ];
}

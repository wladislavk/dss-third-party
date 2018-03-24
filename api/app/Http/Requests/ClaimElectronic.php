<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimElectronic extends Request
{
    protected $rules = [
        'claimid'         => 'required|integer',
        'response'        => 'required|string',
        'reference_id'    => 'string',
        'percase_date'    => 'date',
        'percase_name'    => 'string',
        'percase_amount'  => 'regex:/^\d*(\.\d{2})?$/',
        'percase_status'  => 'integer',
        'percase_invoice' => 'integer',
        'percase_free'    => 'integer',
    ];
}

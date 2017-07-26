<?php

namespace DentalSleepSolutions\Http\Requests;

class ExternalCompany extends Request
{
    protected $rules = [
        'software' => 'required|string',
        'name' => 'required|string',
        'short_name' => 'required|string',
        'api_key' => 'required|string',
        'valid_from' => 'required|string',
        'valid_to' => 'required|string',
        'url' => 'string',
        'description' => 'string',
        'status' => 'required|integer',
        'reason' => 'string',
    ];
}

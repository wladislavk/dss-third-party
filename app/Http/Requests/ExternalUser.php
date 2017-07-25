<?php

namespace DentalSleepSolutions\Http\Requests;

class ExternalUser extends Request
{
    protected $rules = [
        'user_id' => 'required|integer',
        'api_key' => 'required|string',
        'valid_from' => 'required|string',
        'valid_to' => 'required|string',
        'enabled' => 'required|boolean',
    ];
}

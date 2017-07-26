<?php

namespace DentalSleepSolutions\Http\Requests;

class UserSignature extends Request
{
    protected $rules = [
        'user_id'        => 'required|integer',
        'signature_json' => 'required|json',
    ];
}

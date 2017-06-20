<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomLetterTemplate extends Request
{
    protected $rules = [
        'name'   => 'required|string',
        'body'   => 'string',
        'docid'  => 'required|integer',
        'status' => 'integer',
    ];
}

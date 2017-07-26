<?php

namespace DentalSleepSolutions\Http\Requests;

class LetterTemplate extends Request
{
    protected $rules = [
        'name'           => 'required|string',
        'template'       => 'regex:/^\/manage\/([a-z]+_)+[a-z]+\.php$/',
        'body'           => 'string',
        'default_letter' => 'integer',
        'companyid'      => 'required|integer',
        'triggerid'      => 'required|integer',
    ];
}

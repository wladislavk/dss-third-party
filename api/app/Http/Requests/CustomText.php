<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomText extends Request
{
    protected $rules = [
        'title'        => 'required|string',
        'description'  => 'required|string',
        'docid'        => 'required|integer',
        'status'       => 'required|integer',
        'default_text' => 'integer'
    ];
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportCategory extends Request
{
    protected $rules = [
        'title'  => 'required|string',
        'status' => 'integer',
    ];
}

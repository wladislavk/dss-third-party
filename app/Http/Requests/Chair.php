<?php

namespace DentalSleepSolutions\Http\Requests;

class Chair extends Request
{
    protected $rules = [
        'name'  => 'required|string',
        'rank'  => 'integer',
        'docid' => 'required|integer',
    ];
}

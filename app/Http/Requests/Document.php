<?php

namespace DentalSleepSolutions\Http\Requests;

class Document extends Request
{
    protected $rules = [
        'categoryid' => 'required|integer',
        'name'       => 'required|string',
        'filename'   => 'required|string',
    ];
}

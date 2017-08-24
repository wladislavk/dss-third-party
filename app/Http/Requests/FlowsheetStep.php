<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetStep extends Request
{
    protected $rules = [
        'name'    => 'required|string',
        'sort_by' => 'integer',
        'section' => 'required|integer',
    ];
}

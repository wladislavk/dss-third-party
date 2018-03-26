<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetSegment extends Request
{
    protected $rules = [
        'section' => 'required|string',
        'content' => 'string',
        'sortby'  => 'integer',
    ];
}

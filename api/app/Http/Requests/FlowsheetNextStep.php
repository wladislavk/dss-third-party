<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetNextStep extends Request
{
    protected $rules = [
        'parent_id' => 'required|integer',
        'child_id'  => 'required|integer',
        'sort_by'   => 'required|integer',
    ];
}

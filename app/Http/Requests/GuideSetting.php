<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideSetting extends Request
{
    protected $rules = [
        'name'              => 'required|string',
        'setting_type'      => 'integer',
        'range_start'       => 'integer',
        'range_end'         => 'integer',
        'rank'              => 'integer',
        'options'           => 'integer',
        'range_start_label' => 'string',
        'range_end_label'   => 'string',
    ];
}

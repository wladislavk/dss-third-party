<?php

namespace DentalSleepSolutions\Http\Requests;

class PlanText extends Request
{
    protected $rules = [
        'plan_text' => 'required|string',
        'status'    => 'integer',
    ];
}

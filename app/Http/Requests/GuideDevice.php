<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideDevice extends Request
{
    protected $rules = [
        'name' => 'required|string',
    ];

    public function updateRules()
    {
        return $this->rules;
    }
}

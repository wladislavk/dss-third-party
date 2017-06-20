<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideSettingOption extends Request
{
    protected $rules = [
        'option_id'  => 'required|integer',
        'setting_id' => 'required|integer',
        'label'      => 'required|string',
    ];
}

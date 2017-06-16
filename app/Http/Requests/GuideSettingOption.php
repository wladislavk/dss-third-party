<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideSettingOption extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'option_id'  => 'required|integer',
            'setting_id' => 'required|integer',
            'label'      => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'option_id'  => 'sometimes|required|integer',
            'setting_id' => 'sometimes|required|integer',
            'label'      => 'sometimes|required|string'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideSettingOptionUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'option_id'  => 'sometimes|required|integer',
            'setting_id' => 'sometimes|required|integer',
            'label'      => 'sometimes|required|string'
        ];
    }
}

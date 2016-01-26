<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideSettingOptionStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'option_id'  => 'required|integer',
            'setting_id' => 'required|integer',
            'label'      => 'required|string'
        ];
    }
}

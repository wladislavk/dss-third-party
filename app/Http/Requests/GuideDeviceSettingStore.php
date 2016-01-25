<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideDeviceSettingStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device_id'  => 'required|integer',
            'setting_id' => 'required|integer',
            'value'      => 'required|integer'
        ];
    }
}

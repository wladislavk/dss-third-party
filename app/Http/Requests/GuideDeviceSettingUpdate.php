<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideDeviceSettingUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device_id'  => 'sometimes|required|integer',
            'setting_id' => 'sometimes|required|integer',
            'value'      => 'sometimes|required|integer'
        ];
    }
}

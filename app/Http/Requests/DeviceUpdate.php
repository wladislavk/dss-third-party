<?php

namespace DentalSleepSolutions\Http\Requests;

class DeviceUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device'      => 'sometimes|required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'image_path'  => 'sometimes|required|string'
        ];
    }
}

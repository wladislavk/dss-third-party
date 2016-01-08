<?php

namespace DentalSleepSolutions\Http\Requests;

class DeviceStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device'      => 'required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'image_path'  => 'required|string'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class Device extends Request
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
            'device'      => 'required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'image_path'  => 'required|string'
        ];
    }

    public function updateRules()
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

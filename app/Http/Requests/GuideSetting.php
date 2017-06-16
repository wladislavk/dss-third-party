<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideSetting extends Request
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
            'name'              => 'required|string',
            'setting_type'      => 'integer',
            'range_start'       => 'integer',
            'range_end'         => 'integer',
            'rank'              => 'integer',
            'options'           => 'integer',
            'range_start_label' => 'string',
            'range_end_label'   => 'string'
        ];
    }

    public function updateRules()
    {
        return [
            'name'              => 'sometimes|required|string',
            'setting_type'      => 'integer',
            'range_start'       => 'integer',
            'range_end'         => 'integer',
            'rank'              => 'integer',
            'options'           => 'integer',
            'range_start_label' => 'string',
            'range_end_label'   => 'string'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideSettingStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
}

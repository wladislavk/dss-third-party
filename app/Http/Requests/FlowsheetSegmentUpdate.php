<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetSegmentUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'section' => 'sometimes|required|string',
            'content' => 'string',
            'sortby'  => 'integer'
        ];
    }
}

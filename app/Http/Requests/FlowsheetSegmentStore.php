<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetSegmentStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'section' => 'required|string',
            'content' => 'string',
            'sortby'  => 'integer'
        ];
    }
}

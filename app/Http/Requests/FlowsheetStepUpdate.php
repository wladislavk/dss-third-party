<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetStepUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'sometimes|required|string',
            'sort_by' => 'integer',
            'section' => 'sometimes|required|integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetNextStepStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => 'required|integer',
            'child_id'  => 'required|integer',
            'sort_by'   => 'required|integer'
        ];
    }
}

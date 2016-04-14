<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetNextStepUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => 'sometimes|required|integer',
            'child_id'  => 'sometimes|required|integer',
            'sort_by'   => 'sometimes|required|integer'
        ];
    }
}

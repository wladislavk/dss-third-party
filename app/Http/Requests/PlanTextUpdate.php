<?php

namespace DentalSleepSolutions\Http\Requests;

class PlanTextUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plan_text' => 'sometimes|required|string',
            'status'    => 'integer'
        ];
    }
}

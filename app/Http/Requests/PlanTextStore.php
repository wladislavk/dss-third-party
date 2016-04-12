<?php

namespace DentalSleepSolutions\Http\Requests;

class PlanTextStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plan_text' => 'required|string',
            'status'    => 'integer'
        ];
    }
}

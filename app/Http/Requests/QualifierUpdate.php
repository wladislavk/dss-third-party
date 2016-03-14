<?php

namespace DentalSleepSolutions\Http\Requests;

class QualifierUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'qualifier'   => 'sometimes|required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer'
        ];
    }
}

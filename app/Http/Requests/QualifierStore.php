<?php

namespace DentalSleepSolutions\Http\Requests;

class QualifierStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'qualifier'   => 'required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer'
        ];
    }
}

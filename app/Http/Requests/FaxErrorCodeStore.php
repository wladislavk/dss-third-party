<?php

namespace DentalSleepSolutions\Http\Requests;

class FaxErrorCodeStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'error_code'  => 'required|string',
            'description' => 'required|string',
            'resolution'  => 'required|string'
        ];
    }
}

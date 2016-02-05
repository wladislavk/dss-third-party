<?php

namespace DentalSleepSolutions\Http\Requests;

class FaxErrorCodeUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'error_code'  => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'resolution'  => 'sometimes|required|string'
        ];
    }
}

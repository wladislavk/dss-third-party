<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimTextStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|string',
            'description' => 'required|string'
        ];
    }
}

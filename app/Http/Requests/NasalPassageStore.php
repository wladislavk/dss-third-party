<?php

namespace DentalSleepSolutions\Http\Requests;

class NasalPassageStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nasal_passages' => 'required|string',
            'description'    => 'string',
            'sortby'         => 'integer',
            'status'         => 'integer'
        ];
    }
}

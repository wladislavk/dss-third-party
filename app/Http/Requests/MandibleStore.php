<?php

namespace DentalSleepSolutions\Http\Requests;

class MandibleStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mandible'    => 'required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer'
        ];
    }
}

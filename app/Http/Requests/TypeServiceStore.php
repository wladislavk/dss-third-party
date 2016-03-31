<?php

namespace DentalSleepSolutions\Http\Requests;

class TypeServiceStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_service' => 'required|string',
            'description'  => 'string',
            'sortby'       => 'integer',
            'status'       => 'required|integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class TypeServiceUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_service' => 'sometimes|required|string',
            'description'  => 'string',
            'sortby'       => 'integer',
            'status'       => 'sometimes|required|integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class PlaceServiceUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'place_service' => 'sometimes|required|string',
            'description'   => 'string',
            'sortby'        => 'integer',
            'status'        => 'integer'
        ];
    }
}

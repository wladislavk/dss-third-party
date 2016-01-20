<?php

namespace DentalSleepSolutions\Http\Requests;

class AllergenUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'allergens'   => 'sometimes|required|string|unique:dental_allergens',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer'
        ];
    }
}

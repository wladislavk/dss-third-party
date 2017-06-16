<?php

namespace DentalSleepSolutions\Http\Requests;

class Allergen extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'allergens'   => 'required|string|unique:dental_allergens',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'allergens'   => 'sometimes|required|string|unique:dental_allergens',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer'
        ];
    }
}

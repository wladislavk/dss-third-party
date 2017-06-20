<?php

namespace DentalSleepSolutions\Http\Requests;

class Allergen extends Request
{
    protected $rules = [
        'allergens'   => 'required|string|unique:dental_allergens',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class PlaceService extends Request
{
    protected $rules = [
        'place_service' => 'required|string',
        'description'   => 'string',
        'sortby'        => 'integer',
        'status'        => 'integer',
    ];
}

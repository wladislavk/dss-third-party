<?php

namespace DentalSleepSolutions\Http\Requests;

class PlaceService extends Request
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
            'place_service' => 'required|string',
            'description'   => 'string',
            'sortby'        => 'integer',
            'status'        => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'place_service' => 'sometimes|required|string',
            'description'   => 'string',
            'sortby'        => 'integer',
            'status'        => 'integer'
        ];
    }
}

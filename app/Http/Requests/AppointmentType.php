<?php

namespace DentalSleepSolutions\Http\Requests;

class AppointmentType extends Request
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
            'name'      => 'string',
            'color'     => 'required|string',
            'classname' => 'required|string',
            'docid'     => 'required|integer'
        ];
    }

    public function updateRules()
    {
        return [
            'name'      => 'string',
            'color'     => 'sometimes|required|string',
            'classname' => 'sometimes|required|string',
            'docid'     => 'sometimes|required|integer'
        ];
    }
}

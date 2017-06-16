<?php

namespace DentalSleepSolutions\Http\Requests;

class AccessCode extends Request
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
            'access_code' => 'required|string|unique:dental_access_codes',
            'notes'       => 'string',
            'status'      => 'integer',
            'plan_id'     => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'access_code' => 'sometimes|required|string|unique:dental_access_codes',
            'notes'       => 'string',
            'status'      => 'integer',
            'plan_id'     => 'integer'
        ];
    }
}

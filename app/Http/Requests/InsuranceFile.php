<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceFile extends Request
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
            'claimid'     => 'required|integer',
            'claimtype'   => ['required', 'regex:/^(?:primary|secondary)$/'],
            'filename'    => 'required|string',
            'description' => 'string',
            'status'      => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'claimid'     => 'sometimes|required|integer',
            'claimtype'   => ['sometimes', 'required', 'regex:/^(?:primary|secondary)$/'],
            'filename'    => 'sometimes|required|string',
            'description' => 'string',
            'status'      => 'integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class Chair extends Request
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
            'name'  => 'required|string',
            'rank'  => 'integer',
            'docid' => 'required|integer'
        ];
    }

    public function updateRules()
    {
        return [
            'name'  => 'sometimes|required|string',
            'rank'  => 'integer',
            'docid' => 'sometimes|required|integer'
        ];
    }
}

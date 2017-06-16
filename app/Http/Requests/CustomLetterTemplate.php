<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomLetterTemplate extends Request
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
            'name'   => 'required|string',
            'body'   => 'string',
            'docid'  => 'required|integer',
            'status' => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'name'   => 'sometimes|required|string',
            'body'   => 'string',
            'docid'  => 'sometimes|required|integer',
            'status' => 'integer'
        ];
    }
}

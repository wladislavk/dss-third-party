<?php

namespace DentalSleepSolutions\Http\Requests;

class Document extends Request
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
            'categoryid' => 'required|integer',
            'name'       => 'required|string',
            'filename'   => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'categoryid' => 'sometimes|required|integer',
            'name'       => 'sometimes|required|string',
            'filename'   => 'sometimes|required|string'
        ];
    }
}

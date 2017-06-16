<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomText extends Request
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
            'title'        => 'required|string',
            'description'  => 'required|string',
            'docid'        => 'required|integer',
            'status'       => 'required|integer',
            'default_text' => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'title'        => 'sometimes|required|string',
            'description'  => 'sometimes|required|string',
            'docid'        => 'sometimes|required|integer',
            'status'       => 'sometimes|required|integer',
            'default_text' => 'integer'
        ];
    }
}

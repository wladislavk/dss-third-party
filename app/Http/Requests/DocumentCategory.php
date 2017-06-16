<?php

namespace DentalSleepSolutions\Http\Requests;

class DocumentCategory extends Request
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
            'status' => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'name'   => 'sometimes|required|string',
            'status' => 'integer'
        ];
    }
}

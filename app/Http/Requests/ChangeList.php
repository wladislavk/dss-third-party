<?php

namespace DentalSleepSolutions\Http\Requests;

class ChangeList extends Request
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
            'content' => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'content' => 'sometimes|required|string'
        ];
    }
}

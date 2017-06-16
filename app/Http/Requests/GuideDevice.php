<?php

namespace DentalSleepSolutions\Http\Requests;

class GuideDevice extends Request
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
            'name' => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'name' => 'required|string'
        ];
    }
}

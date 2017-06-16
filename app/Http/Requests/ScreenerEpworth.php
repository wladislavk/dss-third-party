<?php

namespace DentalSleepSolutions\Http\Requests;

class ScreenerEpworth extends Request
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
            'screener_id' => 'required|integer',
            'epworth_id'  => 'required|integer',
            'response'    => 'required|integer'
        ];
    }

    public function updateRules()
    {
        return [
            'screener_id' => 'sometimes|required|integer',
            'epworth_id'  => 'sometimes|required|integer',
            'response'    => 'sometimes|required|integer'
        ];
    }
}

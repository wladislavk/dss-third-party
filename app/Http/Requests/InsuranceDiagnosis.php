<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDiagnosis extends Request
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
            'ins_diagnosis' => 'required|string',
            'description'   => 'string',
            'sortby'        => 'integer',
            'status'        => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'ins_diagnosis' => 'sometimes|required|string',
            'description'   => 'string',
            'sortby'        => 'integer',
            'status'        => 'integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class SleepTest extends Request
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
            'formid'           => 'integer',
            'patientid'        => 'required|integer',
            'epworthid'        => ['regex:/^([0-9]{1,2}\|[0-9]{1,2}~)+$/'],
            'analysis'         => 'string',
            'userid'           => 'required|integer',
            'docid'            => 'required|integer',
            'status'           => 'integer',
            'parent_patientid' => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'formid'           => 'integer',
            'patientid'        => 'sometimes|required|integer',
            'epworthid'        => ['regex:/^([0-9]{1,2}\|[0-9]{1,2}~)+$/'],
            'analysis'         => 'string',
            'userid'           => 'sometimes|required|integer',
            'docid'            => 'sometimes|required|integer',
            'status'           => 'integer',
            'parent_patientid' => 'integer'
        ];
    }
}

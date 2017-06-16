<?php

namespace DentalSleepSolutions\Http\Requests;

class Task extends Request
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
            'task'           => 'required|string',
            'description'    => 'string',
            'userid'         => 'required|integer',
            'responsibleid'  => 'required|integer',
            'status'         => 'integer',
            'due_date'       => 'date',
            'recurring'      => 'integer',
            'recurring_unit' => 'integer',
            'patientid'      => 'required|integer'
        ];
    }

    public function updateRules()
    {
        return [
            'task'           => 'sometimes|required|string',
            'description'    => 'string',
            'userid'         => 'sometimes|required|integer',
            'responsibleid'  => 'sometimes|required|integer',
            'status'         => 'integer',
            'due_date'       => 'date',
            'recurring'      => 'integer',
            'recurring_unit' => 'integer',
            'patientid'      => 'sometimes|required|integer'
        ];
    }
}

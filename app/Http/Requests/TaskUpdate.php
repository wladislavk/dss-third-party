<?php

namespace DentalSleepSolutions\Http\Requests;

class TaskUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

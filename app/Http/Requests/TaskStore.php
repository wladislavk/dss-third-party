<?php

namespace DentalSleepSolutions\Http\Requests;

class TaskStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
}

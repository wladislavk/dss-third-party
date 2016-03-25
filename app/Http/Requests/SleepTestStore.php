<?php

namespace DentalSleepSolutions\Http\Requests;

class SleepTestStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class SleepTestUpdate extends Request
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
            'patientid'        => 'sometimes|required|integer',
            'epworthid'        => 'regex:/^([0-9]{1,2}\|[0-9]{1,2}~)+$/',
            'analysis'         => 'string',
            'userid'           => 'sometimes|required|integer',
            'docid'            => 'sometimes|required|integer',
            'status'           => 'integer',
            'parent_patientid' => 'integer'
        ];
    }
}

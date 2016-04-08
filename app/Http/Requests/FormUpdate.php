<?php

namespace DentalSleepSolutions\Http\Requests;

class FormUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'     => 'sometimes|required|integer',
            'patientid' => 'sometimes|required|integer',
            'formtype'  => 'integer'
        ];
    }
}

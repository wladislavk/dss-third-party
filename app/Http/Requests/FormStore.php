<?php

namespace DentalSleepSolutions\Http\Requests;

class FormStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'     => 'required|integer',
            'patientid' => 'required|integer',
            'formtype'  => 'integer'
        ];
    }
}

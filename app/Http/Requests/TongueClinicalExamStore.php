<?php

namespace DentalSleepSolutions\Http\Requests;

class TongueClinicalExamStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'               => 'required|integer',
            'patientid'            => 'required|integer',
            'blood_pressure'       => ['regex:/^[1-2][0-9]{2}\/([5-9][0-9]|1[0-9]{2})$/'],
            'pulse'                => 'string',
            'neck_measurement'     => 'regex:/^([0-9]*[.])?[0-9]+$/',
            'bmi'                  => 'regex:/^[0-9]+\.[0-9]+$/',
            'additional_paragraph' => 'string',
            'tongue'               => 'regex:/^~([0-9]~)+$/',
            'userid'               => 'integer',
            'docid'                => 'integer',
            'status'               => 'integer'
        ];
    }
}

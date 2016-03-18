<?php

namespace DentalSleepSolutions\Http\Requests;

class SleepStudyUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'testnumber'         => 'sometimes|required|regex:/^[0-9]{9}$/',
            'docid'              => 'sometimes|required|regex:/^[0-9]+$/',
            'patientid'          => 'sometimes|required|regex:/^[0-9]+',
            'needed'             => ['regex:/^(?:Yes|No)$/'],
            'scheddate'          => 'date',
            'sleeplabwheresched' => 'sometimes|required|regex:/^[0-9]+',
            'completed'          => ['regex:/^(?:Yes|No)$/'],
            'interpolation'      => ['regex:/^(?:Yes|No)$/'],
            'labtype'            => ['sometimes', 'required', 'regex:/^(?:PSG|HST)$/'],
            'copyreqdate'        => 'date',
            'sleeplab'           => 'sometimes|required|regex:/^[0-9]+',
            'scanext'            => ['regex:/^(?:jpg|docx|rtf|pdf)$/'],
            'date'               => 'sometimes|required|regex:/^[0-9]{8}',
            'filename'           => 'regex:/[a-z0-9_]{15}/'
        ];
    }
}

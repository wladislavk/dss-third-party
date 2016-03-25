<?php

namespace DentalSleepSolutions\Http\Requests;

class SleepStudyStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'testnumber'         => 'required|regex:/^[0-9]{9}$/',
            'docid'              => 'required|regex:/^[0-9]+$/',
            'patientid'          => 'required|regex:/^[0-9]+$/',
            'needed'             => ['regex:/^(?:Yes|No)$/'],
            'scheddate'          => 'date',
            'sleeplabwheresched' => 'required|regex:/^[0-9]+$/',
            'completed'          => ['regex:/^(?:Yes|No)$/'],
            'interpolation'      => ['regex:/^(?:Yes|No)$/'],
            'labtype'            => ['required', 'regex:/^(?:PSG|HST)$/'],
            'copyreqdate'        => 'date',
            'sleeplab'           => 'required|regex:/^[0-9]+$/',
            'scanext'            => ['regex:/^(?:jpg|docx|rtf|pdf)$/'],
            'date'               => 'required|regex:/^[0-9]{8}$/',
            'filename'           => 'regex:/^[a-z0-9_]{15}$/'
        ];
    }
}

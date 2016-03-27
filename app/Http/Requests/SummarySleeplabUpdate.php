<?php

namespace DentalSleepSolutions\Http\Requests;

class SummarySleeplabUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date'             => 'sometimes|required|date',
            'sleeptesttype'    => 'sometimes|required|string',
            'place'            => 'string',
            'apnea'            => 'string',
            'hypopnea'         => 'string',
            'ahi'              => 'string',
            'ahisupine'        => 'string',
            'rdi'              => 'string',
            'rdisupine'        => 'string',
            'o2nadir'          => 'string',
            't9002'            => 'string',
            'sleepefficiency'  => 'string',
            'cpaplevel'        => 'string',
            'dentaldevice'     => 'regex:/^[0-9]+$/',
            'devicesetting'    => 'string',
            'diagnosis'        => 'string',
            'notes'            => 'string',
            'patiendid'        => 'sometimes|required|regex:/^[0-9]+$/',
            'filename'         => ['regex:/^[a-z0-9_]+\.(jpg|gif|png|bmp)$/'],
            'testnumber'       => 'regex:/^[0-9]{9}$/',
            'needed'           => ['regex:/^(?:No|Yes)$/'],
            'scheddate'        => 'date',
            'completed'        => ['regex:/^(?:No|Yes)$/'],
            'interpolation'    => ['regex:/^(?:No|Yes)$/'],
            'copyreqdate'      => 'date',
            'sleeplab'         => 'regex:/^[0-9]+$/',
            'diagnosising_doc' => 'string',
            'diagnosising_npi' => 'string',
            'image_id'         => 'regex:/^[0-9]+$/'
        ];
    }
}

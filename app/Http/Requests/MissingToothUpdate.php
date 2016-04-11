<?php

namespace DentalSleepSolutions\Http\Requests;

class MissingToothUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'    => 'integer',
            'patientid' => 'sometimes|required|integer',
            'pck'       => 'regex:/^(?:~[0-9]*)+$/',
            'rec'       => 'regex:/^(?:~[0-9]*)+$/',
            'mob'       => 'regex:/^(?:~[0-9]*)+$/',
            'rec1'      => 'regex:/^(?:~[0-9]*)+$/',
            'pck1'      => 'regex:/^(?:~[0-9]*)+$/',
            's1'        => 'integer',
            's2'        => 'integer',
            's3'        => 'integer',
            's4'        => 'integer',
            's5'        => 'integer',
            's6'        => 'integer',
            'userid'    => 'sometimes|required|integer',
            'docid'     => 'sometimes|required|integer',
            'status'    => 'integer'
        ];
    }
}

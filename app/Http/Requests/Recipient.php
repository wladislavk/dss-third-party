<?php

namespace DentalSleepSolutions\Http\Requests;

class Recipient extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'formid'              => 'integer',
            'patientid'           => 'required|integer',
            'referring_physician' => 'string',
            'dentist'             => 'string',
            'physicians_other'    => 'string',
            'patient_info'        => 'string',
            'q_file1'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file2'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file3'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file4'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file5'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'userid'              => 'required|integer',
            'docid'               => 'required|integer',
            'status'              => 'integer',
            'q_file6'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file7'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file8'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file9'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file10'            => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/']
        ];
    }

    public function updateRules()
    {
        return [
            'formid'              => 'integer',
            'patientid'           => 'sometimes|required|integer',
            'referring_physician' => 'string',
            'dentist'             => 'string',
            'physicians_other'    => 'string',
            'patient_info'        => 'string',
            'q_file1'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file2'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file3'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file4'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file5'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'userid'              => 'sometimes|required|integer',
            'docid'               => 'sometimes|required|integer',
            'status'              => 'integer',
            'q_file6'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file7'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file8'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file9'             => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/'],
            'q_file10'            => ['regex:/^[a-z0-9]{12}\.(gif|png|jpg)$/']
        ];
    }
}

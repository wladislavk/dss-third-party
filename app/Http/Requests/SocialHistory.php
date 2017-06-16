<?php

namespace DentalSleepSolutions\Http\Requests;

class SocialHistory extends Request
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
            'formid'               => 'integer',
            'patientid'            => 'required|integer',
            'family_had'           => 'string',
            'family_diagnosed'     => ['regex:/^(:?Yes|No)$/'],
            'additional_paragraph' => 'string',
            'alcohol'              => 'string',
            'sedative'             => 'string',
            'caffeine'             => 'string',
            'smoke'                => ['regex:/^(:?Yes|No)$/'],
            'smoke_packs'          => 'regex:/^[0-9]{1,2}$/',
            'tobacco'              => ['regex:/^(:?Yes|No)$/'],
            'userid'               => 'required|integer',
            'docid'                => 'required|integer',
            'status'               => 'integer',
            'parent_patientid'     => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'formid'               => 'integer',
            'patientid'            => 'sometimes|required|integer',
            'family_had'           => 'string',
            'family_diagnosed'     => ['regex:/^(:?Yes|No)$/'],
            'additional_paragraph' => 'string',
            'alcohol'              => 'string',
            'sedative'             => 'string',
            'caffeine'             => 'string',
            'smoke'                => ['regex:/^(:?Yes|No)$/'],
            'smoke_packs'          => 'regex:/^[0-9]{1,2}$/',
            'tobacco'              => ['regex:/^(:?Yes|No)$/'],
            'userid'               => 'sometimes|required|integer',
            'docid'                => 'sometimes|required|integer',
            'status'               => 'integer',
            'parent_patientid'     => 'integer'
        ];
    }
}

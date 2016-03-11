<?php

namespace DentalSleepSolutions\Http\Requests;

class SocialHistoryUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

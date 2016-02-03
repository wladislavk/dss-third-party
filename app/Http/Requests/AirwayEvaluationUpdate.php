<?php

namespace DentalSleepSolutions\Http\Requests;

class AirwayEvaluationUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'               => 'sometimes|required|integer',
            'patientid'            => 'sometimes|required|integer',
            'maxilla'              => 'regex:/^~([0-9]~)+$/',
            'other_maxilla'        => 'string',
            'mandible'             => 'regex:/^~([0-9]~)+$/',
            'other_mandible'       => 'string',
            'soft_palate'          => 'regex:/^~([0-9]~)+$/',
            'other_soft_palate'    => 'string',
            'uvula'                => 'regex:/^~([0-9]~)+$/',
            'other_uvula'          => 'string',
            'gag_reflex'           => 'regex:/^~([0-9]~)+$/',
            'other_gag_reflex'     => 'string',
            'nasal_passages'       => 'regex:/^~([0-9]~)+$/',
            'other_nasal_passages' => 'string',
            'userid'               => 'integer',
            'docid'                => 'integer',
            'status'               => 'integer'
        ];
    }
}

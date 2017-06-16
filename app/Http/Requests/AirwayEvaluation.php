<?php

namespace DentalSleepSolutions\Http\Requests;

class AirwayEvaluation extends Request
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
            'userid'               => 'required|integer',
            'docid'                => 'required|integer',
            'status'               => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'formid'               => 'integer',
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
            'userid'               => 'sometimes|required|integer',
            'docid'                => 'sometimes|required|integer',
            'status'               => 'integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDocument extends Request
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
            'title'       => 'required|string',
            'description' => 'required|string',
            'video_file'  => 'string',
            'doc_file'    => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'docid'       => 'string'
        ];
    }

    public function updateRules()
    {
        return [
            'title'       => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'video_file'  => 'string',
            'doc_file'    => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'docid'       => 'string'
        ];
    }
}

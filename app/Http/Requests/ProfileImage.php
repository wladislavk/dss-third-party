<?php

namespace DentalSleepSolutions\Http\Requests;

class ProfileImage extends Request
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
            'formid'      => 'integer',
            'patientid'   => 'required|integer',
            'title'       => 'string',
            'image_file'  => 'string',
            'imagetypeid' => 'required|integer',
            'userid'      => 'required|integer',
            'docid'       => 'required|integer',
            'status'      => 'integer',
            'adminid'     => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'formid'      => 'integer',
            'patientid'   => 'sometimes|required|integer',
            'title'       => 'string',
            'image_file'  => 'string',
            'imagetypeid' => 'sometimes|required|integer',
            'userid'      => 'sometimes|required|integer',
            'docid'       => 'sometimes|required|integer',
            'status'      => 'integer',
            'adminid'     => 'integer'
        ];
    }
}

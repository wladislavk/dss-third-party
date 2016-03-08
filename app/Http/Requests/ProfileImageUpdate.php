<?php

namespace DentalSleepSolutions\Http\Requests;

class ProfileImageUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

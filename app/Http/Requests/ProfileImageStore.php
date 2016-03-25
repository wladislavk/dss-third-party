<?php

namespace DentalSleepSolutions\Http\Requests;

class ProfileImageStore extends Request
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
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class EdxCertificateUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url'               => 'sometimes|required|url',
            'edx_id'            => 'sometimes|required|integer',
            'course_name'       => 'string',
            'course_section'    => 'string',
            'course_subsection' => 'string',
            'number_ce'         => 'integer'
        ];
    }
}

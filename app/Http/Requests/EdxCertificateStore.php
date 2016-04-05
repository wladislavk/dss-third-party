<?php

namespace DentalSleepSolutions\Http\Requests;

class EdxCertificateStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url'               => 'required|url',
            'edx_id'            => 'required|integer',
            'course_name'       => 'string',
            'course_section'    => 'string',
            'course_subsection' => 'string',
            'number_ce'         => 'integer'
        ];
    }
}

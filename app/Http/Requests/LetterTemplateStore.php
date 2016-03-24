<?php

namespace DentalSleepSolutions\Http\Requests;

class LetterTemplateStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|string',
            'template'       => 'regex:/^\/manage\/([a-z]+_)+[a-z]+\.php$/',
            'body'           => 'string',
            'default_letter' => 'integer',
            'companyid'      => 'required|integer',
            'triggerid'      => 'required|integer'
        ];
    }
}

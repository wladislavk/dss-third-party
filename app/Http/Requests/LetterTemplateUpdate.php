<?php

namespace DentalSleepSolutions\Http\Requests;

class LetterTemplateUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'sometimes|required|string',
            'template'       => 'regex:/^\/manage\/([a-z]+_)+[a-z]+\.php$/',
            'body'           => 'string',
            'default_letter' => 'integer',
            'companyid'      => 'sometimes|required|integer',
            'triggerid'      => 'sometimes|required|integer'
        ];
    }
}

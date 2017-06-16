<?php

namespace DentalSleepSolutions\Http\Requests;

class LetterTemplate extends Request
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
            'name'           => 'required|string',
            'template'       => 'regex:/^\/manage\/([a-z]+_)+[a-z]+\.php$/',
            'body'           => 'string',
            'default_letter' => 'integer',
            'companyid'      => 'required|integer',
            'triggerid'      => 'required|integer'
        ];
    }

    public function updateRules()
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

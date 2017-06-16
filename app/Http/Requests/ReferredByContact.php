<?php

namespace DentalSleepSolutions\Http\Requests;

class ReferredByContact extends Request
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
            'docid'                => 'integer',
            'salutation'           => 'string',
            'lastname'             => 'required|string',
            'firstname'            => 'required|string',
            'middlename'           => 'string',
            'company'              => 'required|string',
            'add1'                 => 'required|string',
            'add2'                 => 'string',
            'city'                 => 'required|string',
            'state'                => 'required|string',
            'zip'                  => 'required|regex:/^[0-9]{5}$/',
            'phone1'               => 'required|regex:/^[0-9]{10}$/',
            'phone2'               => 'regex:/^[0-9]{10}$/',
            'fax'                  => 'regex:/^[0-9]{10}$/',
            'email'                => 'required|email',
            'national_provider_id' => 'string',
            'qualifier'            => 'integer',
            'qualifierid'          => 'string',
            'greeting'             => 'string',
            'sincerely'            => 'string',
            'notes'                => 'string',
            'status'               => 'integer',
            'preferredcontact'     => 'string',
            'referredby_info'      => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'docid'                => 'integer',
            'salutation'           => 'string',
            'lastname'             => 'sometimes|required|string',
            'firstname'            => 'sometimes|required|string',
            'middlename'           => 'string',
            'company'              => 'sometimes|required|string',
            'add1'                 => 'sometimes|required|string',
            'add2'                 => 'string',
            'city'                 => 'sometimes|required|string',
            'state'                => 'sometimes|required|string',
            'zip'                  => 'sometimes|required|regex:/^[0-9]{5}$/',
            'phone1'               => 'sometimes|required|regex:/^[0-9]{10}$/',
            'phone2'               => 'regex:/^[0-9]{10}$/',
            'fax'                  => 'regex:/^[0-9]{10}$/',
            'email'                => 'sometimes|required|email',
            'national_provider_id' => 'string',
            'qualifier'            => 'integer',
            'qualifierid'          => 'string',
            'greeting'             => 'string',
            'sincerely'            => 'string',
            'notes'                => 'string',
            'status'               => 'integer',
            'preferredcontact'     => 'string',
            'referredby_info'      => 'integer'
        ];
    }
}

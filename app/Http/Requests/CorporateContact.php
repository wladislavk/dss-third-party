<?php

namespace DentalSleepSolutions\Http\Requests;

class CorporateContact extends Request
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
            'docid'         => 'integer',
            'salutation'    => 'string',
            'lastname'      => 'required|string',
            'firstname'     => 'required|string',
            'middlename'    => 'string',
            'company'       => 'required|string',
            'add1'          => 'required|string',
            'add2'          => 'string',
            'city'          => 'required|string',
            'state'         => 'required|string',
            'zip'           => 'required|string',
            'phone1'        => 'required|regex:/^[0-9]{10}$/',
            'phone2'        => 'regex:/^[0-9]{10}$/',
            'fax'           => 'regex:/^[0-9]{10}$/',
            'email'         => 'required|email',
            'greeting'      => 'string',
            'sincerely'     => 'string',
            'contacttypeid' => 'required|integer',
            'notes'         => 'string'
        ];
    }

    public function updateRules()
    {
        return [
            'docid'         => 'integer',
            'salutation'    => 'string',
            'lastname'      => 'sometimes|required|string',
            'firstname'     => 'sometimes|required|string',
            'middlename'    => 'string',
            'company'       => 'sometimes|required|string',
            'add1'          => 'sometimes|required|string',
            'add2'          => 'string',
            'city'          => 'sometimes|required|string',
            'state'         => 'sometimes|required|string',
            'zip'           => 'sometimes|required|string',
            'phone1'        => 'sometimes|required|regex:/^[0-9]{10}$/',
            'phone2'        => 'regex:/^[0-9]{10}$/',
            'fax'           => 'regex:/^[0-9]{10}$/',
            'email'         => 'sometimes|required|email',
            'greeting'      => 'string',
            'sincerely'     => 'string',
            'contacttypeid' => 'sometimes|required|integer',
            'notes'         => 'string'
        ];
    }
}

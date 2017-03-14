<?php

namespace DentalSleepSolutions\Http\Requests;

class ReferredByContactStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
            'qualifier'            => 'string',
            'qualifierid'          => 'string',
            'greeting'             => 'string',
            'sincerely'            => 'string',
            'contacttypeid'        => 'required|integer',
            'notes'                => 'string',
            'status'               => 'integer',
            'preferredcontact'     => 'string',
            'referredby_info'      => 'integer'
        ];
    }
}

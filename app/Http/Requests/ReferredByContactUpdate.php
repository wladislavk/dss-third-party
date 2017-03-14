<?php

namespace DentalSleepSolutions\Http\Requests;

class ReferredByContactUpdate extends Request
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
            'qualifier'            => 'string',
            'qualifierid'          => 'string',
            'greeting'             => 'string',
            'sincerely'            => 'string',
            'contacttypeid'        => 'sometimes|required|integer',
            'notes'                => 'string',
            'status'               => 'integer',
            'preferredcontact'     => 'string',
            'referredby_info'      => 'integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class SleeplabStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'      => 'required|integer',
            'salutation' => 'string',
            'lastname'   => 'required|string',
            'firstname'  => 'required|string',
            'middlename' => 'string',
            'company'    => 'string',
            'add1'       => 'required|string',
            'add2'       => 'string',
            'city'       => 'string',
            'state'      => 'string',
            'zip'        => 'regex:/^[0-9]{5}$/',
            'phone1'     => 'regex:/^[0-9]{10}$/',
            'phone2'     => 'regex:/^[0-9]{10}$/',
            'fax'        => 'regex:/^[0-9]{10}$/',
            'email'      => 'email',
            'greeting'   => 'string',
            'sincerely'  => 'string',
            'notes'      => 'string',
            'status'     => 'integer'
        ];
    }
}

<?php

namespace DentalSleepSolutions\Http\Requests;

class SleeplabUpdate extends AbstractUpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'      => 'integer',
            'salutation' => 'string',
            'lastname'   => 'sometimes|required|string',
            'firstname'  => 'sometimes|required|string',
            'middlename' => 'string',
            'company'    => 'sometimes|required|string',
            'add1'       => 'sometimes|required|string',
            'add2'       => 'string',
            'city'       => 'sometimes|required|string',
            'state'      => 'sometimes|required|string',
            'zip'        => 'sometimes|required|regex:/^[0-9]{5}$/',
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

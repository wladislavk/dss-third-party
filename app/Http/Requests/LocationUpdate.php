<?php

namespace DentalSleepSolutions\Http\Requests;

class LocationUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location'         => 'string',
            'docid'            => 'sometimes|required|integer',
            'name'             => 'string',
            'address'          => 'string',
            'city'             => 'string',
            'state'            => 'string',
            'zip'              => 'regex:/^[0-9]{5}$/',
            'phone'            => 'regex:/^[0-9]{10}$/',
            'fax'              => 'regex:/^[0-9]{10}$/',
            'default_location' => 'boolean',
            'email'            => 'email'
        ];
    }
}
